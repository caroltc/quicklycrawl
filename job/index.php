<?php
namespace QuicklyCrawl;

//引入自动载入函数
include_once 'autoloader.php';

//注册自动加载
Autoloader::register();

$opts = getopt('', array(
    'class:'
));

$runnerClass = $opts['class'];
if(empty($runnerClass)) {
    echo PHP_EOL . 'Use php launcher.php --class=JobDemo --xx=yy --xx=yy' . PHP_EOL;
    exit(1);
}

if(! class_exists($runnerClass)) {
    exit("$runnerClass is not exists\n");
}

$runner = new $runnerClass();
$runner->run();