<?php
namespace QuicklyCrawl\Rule;
use QuicklyCrawl\Config\CrawlConst;
use QuicklyCrawl\Lib;

class ChunjieDeal extends Lib\BaseJob
{
    const FLAG = 'deal';
    const LIMIT = 10;

    public function launch()
    {
        $cursor = $this->getRunedCursor(self::FLAG);
        if(!$cursor){
            $cursor = 0;
            $this->saveRunedCursor(self::FLAG, $cursor);
        }
        while($task_data = Lib\Dao::getInstance()->find(CrawlConst::TABLE_CRAWL_TASK, '`id` > ' . $cursor . ' and `type_id` = ' . CrawlConst::TYPE_ID_CHUNJIE, '*', '`id` asc', self::LIMIT)){
            foreach($task_data as $item){
                $contents = file_get_contents($item['url']);
                $contents = str_replace('<meta charset="UTF-8">', '<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />', $contents);
                $doc = new \DOMDocument();
                $doc->loadHTML($contents);

                $data = array(
                    'id' => $item['id'],
                    'type_id' => CrawlConst::TYPE_ID_CHUNJIE,
                    'updatetime' => date('Y-m-d H:i:s')
                );

                /* go through all nodes which have class="baby" ... */
                $dom = new \DOMXPath($doc);
                $data['title'] =  $doc->getElementsByTagName('title')->item(0)->textContent;
                $data['title'] = str_replace('纯洁网', '', $data['title']);
                $data['title'] = str_replace('|', '', $data['title']);
                $content['title'] = $data['title'];
                preg_match('/<meta +name *=["\']?keywords["\']? *content=["\']?([^<>"]+)["\']?/i', $contents, $res_keywords);
                if (isset ($res_keywords)) {
                    $content['keywords'] = $res_keywords[1];
                    $content['keywords'] = str_replace('纯洁网', '', $content['keywords']);
                }

                preg_match('/<meta +name *=["\']?description["\']? *content=["\']?([^<>"]+)["\']?/i', $contents, $res_description);
                if (isset ($res_description)) {
                    $content['description'] = $res_description[1];
                }

                foreach( $dom->query( '//*[@class="post-content"]' )
                         as $element ){
                    $content['body'] = $doc->saveHTML($element);
                    $content['body'] = preg_replace('/<div class="post-meta-bottom">(.*)<\/div>/is', ' ', $content['body']);
                }

                $data['content'] = htmlentities(json_encode($content));
                $status = Lib\Dao::getInstance()->replace(CrawlConst::TABLE_CRAWL_ITEM, $data);
                if($status){
                    $this->logger($item['id'] . '  ok');
                }else{
                    $this->logger($item['id'] . '  failed');
                }
                $this->saveRunedCursor(self::FLAG, $item['id']);
                $cursor = $this->getRunedCursor(self::FLAG);
                sleep(2);
            }
        }

    }

    /**
     * 规范使用长参数模式例如 --start=1 --end=2
     * @return array
     *     array('start:','end:');
     */
    function getOptArgs()
    {

    }
}