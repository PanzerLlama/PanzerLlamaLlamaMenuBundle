<?php
namespace PanzerLlama\LlamaMenuBundle\Service;

use AdminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

use Twig_Environment as Twig;

use PanzerLlama\LlamaMenuBundle\Model\LlamaMenu;
use PanzerLlama\LlamaMenuBundle\Model\LlamaMenuElement;

class LlamaMenuService
{
    
	private $twig;
    private $router;
    private $requestStack;
    private $authorizationChecker;
    private $tokenStorage;
	
	public function __construct(Twig $twig, Router $router, RequestStack $requestStack, AuthorizationCheckerInterface $authorizationChecker, TokenStorage $tokenStorage)
	{
        $this->twig                 = $twig;
        $this->router               = $router;
        $this->requestStack         = $requestStack;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage         = $tokenStorage;
        $this->user                 = $this->tokenStorage->getToken() ? $this->tokenStorage->getToken()->getUser() : null;
	}
    
    public function renderView(LlamaMenu $menu)
    {
        $this->prepareMenu($menu, $this->requestStack->getCurrentRequest()->get('_route'));
        return $this->twig->render($menu->getOption('template'), array('menu' => $menu));
    }
    
    private function prepareMenu(LlamaMenu $menu, $route)
    {
        /** @var LlamaMenuElement $e */
        foreach ($menu->getElements() as $e)
        {
            $this->prepareMenuElement($e, $route);
        }
    }
    
    private function prepareMenuElement(LlamaMenuElement $menuElement, $route)
    {
        if ($menuElement->getRequiredPermissions())
        {
            if (!$this->user instanceof User || $this->authorizationChecker->isGranted($menuElement->getRequiredPermissions(), $this->user) === false)
            {
                $menuElement->setIsRendered(false);
            }
        }

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
