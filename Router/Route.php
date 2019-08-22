<?php

namespace Involve\Router;

use function FastRoute\simpleDispatcher as Dispatcher;
use FastRoute\RouteCollector;

class Route 
{
    
    protected $dispatcher;
	
	/*
	* Get the route cillection
	*
	*@return void
	*/
    public function routeCollection()
    {
        $this->dispatcher = Dispatcher(function(RouteCollector $router){
            require_once PATH.'/routes/web.php';
            $this->setLog($router->getData());
        });
    }
    
    protected function parseRoute()
    {
    	$dir = dirname($_SERVER['SCRIPT_NAME']);
    	$bs = basename($_SRRVER['SCRIPT_NAME']);
    	// Fetch method and URI from somewhere
    	$httpMethod = $_SERVER['REQUEST_METHOD'];
    	$uri = str_replace([$dir,$base],null,$_SERVER['REQUEST_URI']);
    	if(PHP_SAPI === 'cli-server' || $_SERVER['PHP_SELF'] === '/index.php'){
    		$uri = $_SERVER['REQUEST_URI'];
    	}
    	// Strip query string (?foo=bar) and decode URI
    	if (false !== $pos = strpos($uri, '?')) {
   	 		$uri = substr($uri, 0, $pos);
    	}
    		$uri = rawurldecode($uri);
    		$uri = '/'.ltrim($uri,'/');
    	return $this->dispatcher->dispatch($httpMethod, $uri);
    }
    
    /*
    * Get data Routee
    *
    *@return array
    */
    public function run()
    {
    	return $this->parseRoute();
    }
    
    protected function setLog($log)
    {
    	if(file_exists(PATH.'/routes/log/route.log')){
    		$routes = file_get_contents(PATH.'/routes/web.php');
    		$content = file_get_contents(PATH.'/routes/log/route.log');
    	}
       $date = '['.date('Y-m-d').']
';
       file_put_contents(PATH.'/routes/log/route.log',$date.$routes);
    }

}