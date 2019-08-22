<?php

namespace Involve\Database;

use PDO;

use Involve\Database\Driver;


class DB extends Driver
{
	
	/*
	@var this
	*/
	private static $instance = null;
	
	/*
	* Get new DB
	*
	*@return $this
	*/
	public static function getInstance()
	{
		if(!isset($instance)){
			self::$instance = new DB;
		}
		return self::$instance;
	}
	
	/*
	* Get query and bind
	*/
	public function query($sql,$bind = [])
	{
		$this->prepare($sql,$bind);
		return $this;
	}
	
	/*
	* Get calback FETCH_OBJ
	*/
	public function fetchObj()
	{
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	/*
	* Get calback FETCH_ASSOC
	*/
	public function fetchAssoc()
	{
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/*
	* Get Count 
	*/
	public function count()	
	{
		return $this->stmt->rowCount();
	}
	
}



