<?php


if(!function_exists('render')){
	
	function render(string $view,$data = []){
		$tmpl = new \Involve\View\Template();
		$tmpl->setDir();
		$tmpl->view($view,$data);
	}
	
}

if(!function_exists('e')){
	
	function e($e){
		echo htmlspecialchars($e);
	}
	
}