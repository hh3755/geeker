<?php
/**
 * @author: Jackong
 * Date: 14-3-27
 * Time: 下午1:59
 */

if ($argc < 3) {
    die("usage: $argv[0] <account> <url>\n");
}
require_once __DIR__ . "/../../../../view/env.php";

$start = time();
$account = $argv[1];
$url = $argv[2];
$handler = new \src\service\tieba\Member();
$crawler = new \src\service\Crawler('http://tieba.baidu.com/');
$members = array();
$page = 1;

do {
    \src\common\Log::debug("tieba|member|$account|$page|$url");
    $handler->page($page);
    $members = array_merge($members, $crawler->crawl("$url&pn=$page", $handler));
    $page++;
} while($handler->nextPage());

$members = array_values(array_unique($members));
$collection = \src\common\util\Mongo::collection('tieba.member');
$collection->update(
    array('uid' => $account),
    array(
        'uid' => $account,
        'members' => $members,
        'time' => TIME
    ),
    array('upsert' => true)
);
\src\common\Log::trace("$account|time used: " . (time() - $start));


