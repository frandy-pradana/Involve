<?php

namespace Involve\Database;

use PDO;

class Driver
{
	
	protected $host;
	protected $user;
	protected $pass;
	protected $charset;
	protected $db;
	
	
	protected $stmt;
	
	
	/*
	* Set configure
	*
	*@
	*/
	public function __construct()
	{
		require_once PATH.'/app/configs/db.php';
		$this->host = $db['HOST'];
		$this->user = $db['USER'];
		$this->pass = $db['PASS'];
		$this->db = $db['DB'];
		$this->charset = $db['CHARSET'];
	}
	
	/*
	* Get Pdo connection
	*
	*@return \PDO
	*/
	private function getPdo()
	{
		return $this->conectPdo();
	}
	
	/*
	* Set Connection
	*
	*@return \PDO
	*/
	private function conectPdo()
	{
		$dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
		$options = [
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		];
		
		try{
			return  new PDO($dsn,$this->user,$this->pass,$options);
		}catch(\PDOException $e){
			dd($e);
		}
	}
	
	/*
	* Get prepare / query
	*
	*@param string $query
	*@paran array $bind
	*/
	protected function prepare(string $query,array $binds = [])
	{
		$this->stmt = $this->getPdo()->prepare($query);
		if([] !== $binds){
			foreach($bins as $param => $value){
				$this->bind($param,$value);
			}
		}
		$this->stmt->execute();
	}
	
	/*
	* Bind param value type
	*
	*@param string|int $param
	*@param string|bool|int|null
	*@param donot insert
	*/
	private function bind($param,$value,$type = null)
	{
		if(is_null($type)){
			switch(true){
				case is_int($value):
					$type = PDO::PARAM_INT;
				break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
				break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
				break;
				default :
					$type = PDO::PARAM_STR;
			}
		}
		
		$this->stmt->bindValue($param,$value,$type);
	}
	
}