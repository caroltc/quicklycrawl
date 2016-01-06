<?php
namespace QuicklyCrawl\Rule;
use QuicklyCrawl\Config\CrawlConst;
use QuicklyCrawl\Lib;

class Chunjie extends Lib\BaseJob
{
    const FLAG = 'main';

    public function launch()
    {
        $cursor = $this->getRunedCursor(self::FLAG);
        if(!$cursor){
            $cursor = 0;
            $this->saveRunedCursor(self::FLAG, $cursor);
        }

        $url = array(
            'http://www.chunjie.me/page/0',
            'http://www.chunjie.me/page/1',
            'http://www.chunjie.me/page/2',
            'http://www.chunjie.me/page/3',
            'http://www.chunjie.me/page/4',
            'http://www.chunjie.me/page/5',
            'http://www.chunjie.me/page/6',
            'http://www.chunjie.me/page/7',
            'http://www.chunjie.me/page/8',
            'http://www.chunjie.me/page/9',
            'http://www.chunjie.me/page/10',
        );
        for($i = $cursor; $i < count($url); $i++){
            $contents = file_get_contents($url[$i]);
            $doc = new \DOMDocument();
            $doc->loadHTML($contents);

            /* go through all nodes which have class="baby" ... */
            $dom = new \DOMXPath($doc);
            foreach( $dom->query( '//*[@class="featured-media"]' )
                     as $element ){
                /* and print the result out ... */
                $data = array(
                    'type_id' => CrawlConst::TYPE_ID_CHUNJIE,
                    'url' => $element->getAttribute('href')
                );
                $status = Lib\Dao::getInstance()->replace(CrawlConst::TABLE_CRAWL_TASK, $data);
                if($status){
                    $this->logger($data['url'] . '  ok');
                }else{
                    $this->logger($data['url'] . '  failed');
                }
            }

            sleep(5);
            $this->saveRunedCursor(self::FLAG, $i);
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