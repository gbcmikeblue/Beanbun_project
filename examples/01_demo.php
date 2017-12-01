<?php
/**
 * Created by PhpStorm.
 * User: gbc
 * Date: 17-11-28
 * Time: 上午11:26
 */

use Beanbun\Beanbun;
use Beanbun\Lib\Helper;
use Beanbun\Middleware\Parser;

require_once __DIR__.'/../vendor/autoload.php';

$result_dir = __DIR__ . '/../result_dir/';
$log_dir = __DIR__ . '/../Log/log.log';

$beanbun = new Beanbun;
$beanbun->name = 'tui78';
$beanbun->count = 5;
$beanbun->seed = 'http://www.tui78.com';
$beanbun->max = 30;
$beanbun->logFile = $log_dir;
$beanbun->urlFilter = [
    '/http:\/\/www.tui78.com\/bank\/\S*/'
];

// 加载parser插件
$beanbun->middleware(new Parser());

// 设置字段
$beanbun->fields = [
    [
        'name' => 'title',
        'selector' => ['title', 'text']
    ],
    /*[
        'name' => 'bank_data',
        'children' => [
            [
                'name' => 'title',
                'selector' => ['.tounr p a', 'title'],
                'repeated' => true
            ],
            [
                'name' => 'url',
                'selector' => ['.tounr p a', 'href'],
                'repeated' => true
            ],
        ],
    ]*/
];

// 设置队列
//$beanbun->setQueue('memory', [
//    'host' => '127.0.0.1',
//    'port' => '2207'
//]);

$beanbun->startWorker = function ($beanbun) {
    // 写一条日志
    $beanbun->log("BeanBun start success!{$beanbun->id}");
};

/**
 * @param $beanbun
 */
$beanbun->afterDownloadPage = function($beanbun) use ($result_dir) {
    // 获取
    /*$encode = mb_detect_encoding($beanbun->page, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
    $str = '';
    if ($encode != 'UTF-8') {
        $str = iconv($encode, "UTF-8", $beanbun->page);
    }*/
    $str = json_encode($beanbun->data);

    file_put_contents($result_dir . parse_url($beanbun->url)['host'].'.log', $str);


};

$beanbun->start();