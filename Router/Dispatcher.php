<?php

namespace Involve\Router;

use FastRoute\Dispatcher as Dispatch;


class Dispatcher
{
	
	/*
	* Get found route
	*
	*@param array $info
	*@return void
	*/
	public function handle($info)
	{
		switch ($info[0]) {
			case Dispatch::NOT_FOUND:
				// ... 404 Not Found
		
			break;
			case Dispatch::METHOD_NOT_ALLOWED:
				$allowedMethods = $routeInfo[1];
				// ... 405 Method Not Allowed
			break;
			case Dispatch::FOUND:
				$handler = $info[1];
				$vars = $info[2];
				// ... call $handler with $vars
				$this->handleFoundRoute($handler,$vars);
			break;
		}
	}
	
	/*
	* Get callback for found route
	*
	*@param string\Closure
	*@param array $vars
	*/
	protected function handleFoundRoute($handler,array $vars)
	{
		if(is_callable($handler)){
			$callback = call_user_func_array($handler,$vars);
		}
		
		if(is_string($handler)){
			$handler = explode('@',$handler);
			$namespaceandcontroller = 'App\\Controllers\\'.$handler[0];
			$class = new $namespaceandcontroller();
			
			$callback = call_user_func_array([$class,$handler[1]],$vars);
		}
		
		$this->executeCallback($callback);
		
	}
	
	/*
	* Get callback initilisasi
	*
	*@paeam Object $is_callback
	@return object
	*/
	protected function executeCallback($is_callback)
	{
		if(is_string($is_callback)){
			echo $is_callback;
		}
		
		
		if(is_array($is_callback) || is_object($is_callback) || is_callable($is_callback)){
			dump($is_callback);
		}
		
	}
	

}