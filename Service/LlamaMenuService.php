<?php
namespace PanzerLlama\LlamaMenuBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;

use Twig_Environment as Twig;

use PanzerLlama\LlamaMenuBundle\Model\LlamaMenu;
use PanzerLlama\LlamaMenuBundle\Model\LlamaMenuElement;

class LlamaMenuService
{
    
	private $twig;
    private $router;
    private $requestStack;
    //private $security;
	
	public function __construct(Twig $twig, Router $router, RequestStack $requestStack)
	{
        $this->twig         = $twig;
        $this->router       = $router;
        $this->requestStack = $requestStack;
	}
    
    public function renderView(LlamaMenu $menu)
    {
        $this->prepareMenu($menu, $this->requestStack->getCurrentRequest()->get('_route'));
        return $this->twig->render($menu->getOption('template'), array('menu' => $menu));
    }
    
    private function prepareMenu(LlamaMenu $menu, $route)
    {        
        foreach ($menu->getElements() as $e)
        {
            $this->prepareMenuElement($e, $route);
        }
    }
    
    private function prepareMenuElement(LlamaMenuElement $menuElement, $route)
    {
        $menuElement->addClass(sprintf('level-%s', $menuElement->getLevel()));       
        
        if ($menuElement->hasRoute($route))
        {
            $menuElement->setIsRouted(true);
            $menuElement->setIsActive(true);
        } elseif ($menuElement->hasInRoute($route)) {
            $menuElement->setIsRouted(true);
        }
        
        if ($menuElement->hasDisabledRoute($route))
        {
            $menuElement->setIsDisabled(true);
        }
        
        if ($menuElement->getIsDisabled())
        {
            $menuElement->setUrl('#');        
        }
        
        if ($menuElement->getUrl() === null)
        {
            $menuElement->setUrl($this->router->generate(current($menuElement->getRoutes())));
        }
        
        foreach ($menuElement->getElements() as $e)
        {
            $this->prepareMenuElement($e, $route);
        }
    }
}
