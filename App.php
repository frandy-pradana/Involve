<?php

namespace Involve;

use Involve\Router\Route;
use Involve\Router\Dispatcher;

class App
{
    
    protected $route;

    /*
    * Get router
    *
    *@rturn \involve\Router\Route
    */
    public function bootstrapRoute($path = '')
    {
        $this->route = new Route();
        return $this->route->routeCollection($path);
    }
    
    /*
    * run the applicatiob
    *
    *@return void
    */
    public function run()
    {
    	$this->parseRoute();
    }
    
    /*
    * Get route for parse
    *
    *@
    */
    protected function parseRoute()
    {
    	$info = $this->route->run();
    	$dispatcher = new Dispatcher();
    	$dispatcher->handle($info);
    }
    

}