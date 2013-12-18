<?php
namespace application\geomash\plugin\btlViewer
{
	use nutshell\Nutshell;
	use nutshell\plugin\mvc\Mvc;
	use nutshell\plugin\mvc\Controller as MvcController;
	use nutshell\core\exception\NutshellException;
	
	use application\geomash\helper\MimeHelper;
	
	abstract class Controller extends MvcController
	{
		abstract public function getDocDir();
		
		public $document=null;
		
		public function __construct(Mvc $MVC)
		{
			$this->MVC		=$MVC;
			$this->view		=new View($this->MVC);
			$this->MVC->getModelLoader()->registerContainer('model',APP_HOME.'model'._DS_,'application\model\\');
		}
		
		public function index()
		{
			if (substr($_SERVER['REQUEST_URI'],-1,1)!='/')
			{
				header('Location: '.$_SERVER['REQUEST_URI'].'/');
				exit();
			}
			$this->parseDoc();
			$this->registerViewMethods();
			$this->view->setTemplate('index');
			$this->view->setVar('NS_ENV',NS_ENV);
			$this->view->render();
		}
		
		public function content($ref='index')
		{
			$contents		=file_get_contents($this->getDocDir().$ref.'.md');
			$this->plugin	->Responder()
							->setData($contents)
							->send();
		}
		
		public function asset()
		{
			$args			=func_get_args();
			list(,$type)	=explode('.',end($args));
			$asset			=__DIR__._DS_.'asset'._DS_.implode(_DS_,$args);
			$this->plugin	->Responder($type)
							->setData(file_get_contents($asset))
							->send();
		}
		
		public function getBreadcrumbs($ref)
		{
			$HTML=array('<ul class="breadcrumb">');
			
			$parts		=explode('.',$ref);
			$currentRef	=array();
			for ($i=0,$j=count($parts); $i<$j; $i++)
			{
				$currentRef[]	=$parts[0];
				if (($i+1)!==$j)
				{
					$HTML[]		='<li><a href="#'.implode('.',$currentRef).'">'.ucwords($parts[$i]).'</a> <span class="divider">/</span></li>';
				}
				else
				{
					$HTML[]		='<li class="active">'.ucwords($parts[$i]).'</li>';
				}
			}
			$HTML[]='</ul>';
			$this->plugin	->Responder()
							->setData(implode('',$HTML))
							->send();
		}
		
		private function registerViewMethods()
		{
			$context=$this->view->getContext();
			$scope=$this;
			$context->registerCallback
			(
				'navigation',
				function() use($scope)
				{
					print $scope->generateNav();
				}
			);
		}
		
		private function parseDoc()
		{
			$this->document=json_decode(file_get_contents($this->getDocDir().'doc.json'),true);
			return $this;
		}
		
		public function generateNav()
		{
			$HTML=array('<ul class="nav nav-list">');
			foreach ($this->document['nav'] as $sectionName=>$sectionChildren)
			{
				$HTML[]='<li class="nav-header">'.$sectionName.'</li>';
				foreach ($sectionChildren as $name=>$ref)
				{
					$HTML[]='<li><a href="#'.$ref.'">'.$name.'</a></li>';
				}
			}
			$HTML[]='</ul>';
			return implode('',$HTML);
		}
	}
}
?>