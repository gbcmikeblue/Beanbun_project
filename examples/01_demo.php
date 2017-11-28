<?php
/**
 * Created by PhpStorm.
 * User: gbc
 * Date: 17-11-28
 * Time: 上午11:26
 */

use Beanbun\Beanbun;
use Beanbun\Lib\Helper;

require_once __DIR__.'/../vendor/autoload.php';

$beanbun = new Beanbun;
$beanbun->name = 'demo01';
$beanbun->count = 5;
$beanbun->seed = 'http://www.qiushibaike.com/';
$beanbun->max = 30;
$beanbun->logFile = __DIR__ . '/qiubai_access.log';
$beanbun->urlFilter = [
    '/http:\/\/www.qiushibaike.com\/8hr\/page\/(\d*)\?s=(\d*)/'
];
// 设置队列
$beanbun->setQueue('memory', [
    'host' => '127.0.0.1',
    'port' => '2207'
]);
$beanbun->afterDownloadPage = function($beanbun) {
    file_put_contents(__DIR__ . '/' . md5($beanbun->url), $beanbun->page);
};
$beanbun->start();