<?php
namespace PanzerLlama\LlamaMenuBundle\Extension;

use PanzerLlama\LlamaMenuBundle\Service\LlamaMenuService;

class LlamaMenuExtension extends \Twig_Extension
{	
	private $menuService;
	
	public function __construct(LlamaMenuService $menuService)
    {
		$this->menuService = $menuService;
	}
	
	public function getFunctions()
    {
		return array(
			new \Twig_SimpleFunction('llama_menu_render', array($this, 'menuRender'), array('is_safe' => array('html'))),			
		);
	}
    
    public function menuRender($menu, $options = array())
    {
        if (is_string($menu))
        {
            $className  = '\\'.strtr($menu, array(':' => '\\'));
            
            if(class_exists($className) === false)
            {
                throw new \Exception(sprintf('Menu class "%s" does not exist.', $className));
            }
            $menu  = new $className($options);
        }

        if ($options)
        {
            foreach ($options as $k => $v)
            {
                $menu->setOption($k, $v);
            }
        }
        return $this->menuService->renderView($menu);        
    }
     
	public function getName()
    {
		return 'panzer_llama_llama_menu_extension';
	}	
}