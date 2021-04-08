<?php

/* this is mysql concrete builder. */

// require './BuilderInterface.php'; //使用composer的自动加载，这一行就不再需要了

/**
 * 
 */
class MysqlBuilderClass implements BuilderInterface
{
	// 
	protected $query;

	function __construct(array $config)
	{
		$this->query = new stdClass();
		$this->connect($config);
	}

	public function connect(array $config)
	{
		if (strtolower($config['driver']) != 'mysql') {
			throw new Exception("now only support mysql.", 1);
			
		}
		try{
			$this->query->pdo = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['dbname']}", $config['user'], $config['pass']);
			$this->query->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		// print_r( $this->query->pdo->errorInfo() );
		// print_r($this->query->pdo->errorCode());
		return $this;
	}

	// 关闭pdo连接
	public function close()
	{
		$this->query->pdo = null;
	}

	// 没有预处理
	public function query()
	{
		if (strtolower($this->query->type) != 'select') {
			return ;
		}
		return $this->query->pdo->query($this->getExecutableSql());
	}

	public function exec()
	{
		if (strtolower($this->query->type) == 'select') {
			throw new Exception("not support select, please use query to select", 1);
		}
		return $this->query->pdo->exec($this->getExecutableSql());
	}

	public function select(string $table, array $fields)
	{
		$field_string = '';
		foreach ($fields as $key => $value) {
			$field_string .= $value . ',';
		}
		$field_string = rtrim($field_string, ',');
		// php can set dynamic attributes manually.
		$this->query->sql = "SELECT {$field_string} FROM {$table}";
		$this->query->type = 'select';
		return $this;
	}

	public function where(string $field, $value, $operator)
	{
		if (!in_array(strtolower($this->query->type), ['select', 'update', 'delete'])) {
			throw new Exception("unsupport method on where conditions, only support \"select\", \"update\", \"delete\" method.", 1);
		}

		$this->query->where = " WHERE $field $operator $value ";
		return $this;
	}

	public function limit(int $num, int $start = 0)
	{
		if (strtolower($this->query->type !== 'select')) {
			throw new Exception("limit method only support select SQL query.", 1);
			
		}
		$this->query->limit = " LIMIT $start, $num";
		return $this;
	}

	/**
	 * construct SQL statement like the following format:
	 * ```
	 * INSERT INTO $table $colname $colvalue;
	 * ==
	 * INSERT INTO $table (col1, col2) VALUES (val1, val2);
	 * ```
	 */
	public function insert($table, array $data)
	{
		$colname = '(';
		$colvalue = '(';
		foreach ($data as $key => $value) {
			$colname .= $key . ',';
			$colvalue .= "'" . $value . "'" . ',';
		}
		$colname = rtrim($colname, ',') . ')';
		$colvalue = rtrim($colvalue, ',') . ')';
		$this->query->sql = "INSERT INTO {$table} {$colname} VALUES {$colvalue}";
		$this->query->type = 'insert';
		return $this;
	}

	public function update($table, array $data)
	{
		$string = '';
		foreach ($data as $key => $value) {
			if (is_string($value)) 
				$string .= $key . '=' . "'" . $value . "'" . ',';
			else 
				$string .= $key . '=' . $value . ',';
		}
		$string = rtrim($string, ',');
		$this->query->sql = "UPDATE {$table} SET {$string}";
		$this->query->type = 'update';
		return $this;
	}

	public function delete($table)
	{
		$this->query->sql = "DELETE FROM {$table}";
		$this->query->type = 'delete';
		return $this;
	}

	public function getExecutableSql()
	{
		$sql = '';
		switch ($this->query->type) {
			case 'select':
				$sql = $this->query->sql;
				if (!empty($this->query->where)) {
					$sql .= $this->query->where;
				}
				if (!empty($this->query->limit)) {
					$sql .= $this->query->limit;
				}
				break;
			case 'update':
				$sql = $this->query->sql;
				if (!empty($this->query->where)) {
					$sql .= $this->query->where;
				} 
				break;
			case 'insert':
				$sql = $this->query->sql;
				break;
			case 'delete':
				$sql = $this->query->sql . $this->query->where;
				break;
			default:
				# code...
				break;
		}
		echo $sql;
		return $sql;
	}
}
