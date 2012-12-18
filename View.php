<?php
namespace application\plugin\btlViewer
{
	use nutshell\Nutshell;
	use nutshell\plugin\mvc\Mvc;
	use nutshell\plugin\mvc\View as MvcView;
	use nutshell\core\exception\NutshellException;
	
	class View extends MvcView
	{
		public function __construct(Mvc $MVC)
		{
			parent::__construct($MVC);
			$this->config=$this->plugin->Mvc->config;
		}
		
		public function buildViewPath($viewName)
		{
			return __DIR__._DS_.'view'._DS_.$viewName.'.php';
		}
	}
}