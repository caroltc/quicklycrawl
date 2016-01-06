<?php
namespace QuicklyCrawl\Lib;

/**
 * User: congtang
 * Email: congtang@anjuke.com
 * Date: 15-12-23
 * Time: 下午3:29
 */

abstract class BaseJob {

    protected $commendArgs = array();

    abstract protected function launch();

    public function run()
    {
        $this->logger(str_repeat('*', 10) . " start run " . get_called_class() . " " . str_repeat('*', 10));
        $this->commendArgs = $this->getCommendArgs();
        $this->launch();
        $this->logger(str_repeat('*', 10) . " end run " . get_called_class() . " " . str_repeat('*', 12));
    }

    public function getCommendArgs()
    {
        $rt = array();
        $optArgs = $this->getOptArgs();
        if(! empty($optArgs)) {
            $rt = getopt('', $optArgs);
        }
        return $rt;
    }

    /**
     * 规范使用长参数模式例如 --start=1 --end=2
     * @return array
     *     array('start:','end:');
     */
    abstract function getOptArgs();

    protected function getRunedCursor($identifyFlag)
    {
        return JobCursor::getInstance()->getCursor($this->getRuningClassName(), $identifyFlag);
    }

    protected function saveRunedCursor($identifyFlag, $value)
    {
        return JobCursor::getInstance()->setCursor($this->getRuningClassName(), $identifyFlag, $value);
    }

    private function getRuningClassName()
    {
        return get_called_class();
    }

    /**
     * logger
     * @param string $msg
     */
    protected function logger($msg = '')
    {
      echo PHP_EOL . date('Y-m-d H:i:s') . ': ' . $msg . PHP_EOL;
    }
}