<?php
namespace QuicklyCrawl\Upload;
use QuicklyCrawl\Config\CrawlConst;
use QuicklyCrawl\Lib;

class Upload extends Lib\BaseJob
{
    const FLAG = 'upload';
    const LIMIT = 10;

    public function launch()
    {
        $cursor = $this->getRunedCursor(self::FLAG);
        if(!$cursor){
            $cursor = 0;
            $this->saveRunedCursor(self::FLAG, $cursor);
        }
        while($task_data = Lib\Dao::getInstance()->find(CrawlConst::TABLE_CRAWL_ITEM, '`id` > ' . $cursor . ' and `type_id` = ' . CrawlConst::TYPE_ID_CHUNJIE, '*', '`id` asc', self::LIMIT)){
            print_r($task_data);exit;
                $this->saveRunedCursor(self::FLAG, $item['id']);
                $cursor = $this->getRunedCursor(self::FLAG);
                sleep(2);
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