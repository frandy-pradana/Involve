<?php

namespace Involve\View;

class Template
{
	/*
	*@var string
	*/
	protected $dir = PATH.'/app/resources/views/';
	
	
	/*
	* Set directories for include yor views
	*
	*@param string
	*/
	public function setDir(string $dir = PATH.'/app/resources/views/')
	{
		$this->dir = '/'.trim($dir,'/').'/';
	}
	
	/*
	* Get yor view
	*
	*@return \file_get_contents()
	*/
	public function view(string $view,array $data)
	{
		extract($data);
		$formats = $this->gerFormat();
		foreach($formats as $key => $format){
			if(file_exists($this->dir.trim($view,'/').$format)){
				$content = file_get_contents($this->dir.trim($view,'/').$format);
			}
		}
		
		$regexs = $this->regexs();
		foreach($regexs as $key => $val){
			$content = preg_replace($key,$val,$content);
		}
		
		unset($this->dir);
		eval(' ?>'.$content.'<?php ');
		
	}
	
	/*
	* Get Format php
	*
	*@return void
	*/
	protected function gerFormat()
	{
		$format = [
			'.php',
			'.html',
			'.phtml',
			'.mage',
			'.mage.php',
			'.mage.html',
			'.mage.phtml'
		];
		
		return $format;
	}
	
	protected function regexs()
	{
		$regexs = [
			'/\<php\>(.*)/' => '<?php $1',
			'/\<\/php>/' => '?>',
			'/\{\{(.*)\}\}/' => '<?= htmlspecialchars($1); ?>'
		];
		
		return $regexs;
	}
}