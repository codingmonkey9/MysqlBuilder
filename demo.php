<?php


require './vendor/autoload.php';
// test to connect mysql
$db = require './DBConfig.php';
$mysql = new MysqlBuilderClass($db);

// select test
$res = $mysql->select('api_count', ['id', 'counter'])->where('is_delete', 0, '=')->limit(10)->query();
print_r($res);
foreach ($res as $key => $value) {
	print_r($value);
}

// insert test
// $data = [
// 	'channel_num' => 'test',
// 	'addtime' => time(),
// 	'updatetime' => time(),
// 	'counter' => 3,
// ];
// echo $mysql->insert('api_count', $data)->exec();

// update test
// $data = [
// 	'channel_num' => 'test11',
// 	'updatetime' => time(),
// 	'counter' => 3,
// ];
// echo $mysql->update('api_count', $data)->where('counter', 3, '=')->exec();

// delete test
// echo $mysql->delete('api_count')->where('id', 11, '=')->exec();