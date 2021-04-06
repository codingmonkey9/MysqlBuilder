<?php

/* SQL Builder contains select, update, insert, delete method.
this is an interface of SQL builder. */

interface BuilderInterface
{

	// now only support mysql 
	// $driver, $host, $dbname, $user, $pass, $charset = 'utf8'
	public function connect(array $config);

	// table：表名，fields：要查询的字段
	public function select(string $table, array $fields);

	public function insert($table, array $data);

	public function update($table, array $data);

	public function delete($table);

	// 先只支持一个字段作为条件
	public function where(string $field, $value, string $operator);

	public function limit(int $start, int $num);

	// 
	public function getExecutableSql();

	// insert update delete use this method
	public function exec();

	// select use this method
	public function query();

	public function close();
}