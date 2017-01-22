<?php
namespace PanzerLlama\LlamaMenuBundle\Model;

class LlamaMenuElement
{   
    private $name;
    private $label;
    private $assets;
    private $routes         = array();
    private $inRoutes       = array();
    private $disabledRoutes = array();
    private $url;
    private $level = 1;
    private $menu;
    private $parent;

    private $classes    = array();
    private $elements   = array();

    private $isRouted   = false;
    private $isActive   = false;
    private $isDisabled = false;
    
    public function setName($v)
    {
        $this->name = $v;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setLabel($v)
    {
        $this->label = $v;
        return $this;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function setAssets($assets)
    {
        $this->assets = $assets;
        return $this;
    }
    
    public function getAssets()
    {
        return $this->assets;
    }
    
    public function addAsset($name, $value)
    {
        $this->assets[$name] = $value;
        return $this;
    }
    
    public function getAsset($name)
    {
        return isset($this->assets[$name]) ? (string) $this->assets[$name] : null;
    }
    
    public function hasAsset($name)
    {
        return isset($this->assets[$name]) ? true : false; 
    }
    
    public function addRoute($v)
    {
        $this->routes[] = $v;
        return $this;
    }
    
    public function getRoutes()
    {
        return $this->routes;
    }

    public function hasRoute($v)
    {
        if (in_array($v, $this->routes) !== false)
        {
            return true;
        }
        return false;
    }
   
    public function addInRoute($v)
    {
        $this->inRoutes[] = $v;
        return $this;
    }
    
    public function getInRoutes()
    {
        return $this->inRoutes;
    }
    
    public function hasInRoute($v)
    {
        if (in_array($v, $this->inRoutes) !== false)
        {
            return true;
        }
        return false;
    }
    
    public function addDisabledRoute($v)
    {
        $this->disabledRoutes[] = $v;
        return $this;
    }
    
    public function getDisabledRoutes()
    {
        return $this->disabledRoutes;
    }
    
    public function hasDisabledRoute($v)
    {
        if (in_array($v, $this->disabledRoutes) !== false)
        {
            return true;
        }
        return false;
    }
  
    public function setUrl($v)
    {
        $this->url = $v;
        return $this;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setMenu(LlamaMenu $v)
    {
        $this->menu = $v;
        return $this;
    }
    
    public function getMenu()
    {
        return $this->menu;
    }
    
    public function setParent(LlamaMenuElement $v)
    {
        $this->parent = $v;
        return $this;
    }
    
    public function getParent()
    {
        return $this->parent;
    }
    
    public function setLevel($v)
    {
        $this->level = $v;
        return $this;
    }
    
    public function getLevel()
    {
        return $this->level;
    }
    
    public function setIsRouted($v)
    {
        $this->isRouted = $v;
        if ($this->getParent())
        {
            $this->getParent()->setIsRouted($v);
        }
        return $this;
    }
    
    public function getIsRouted()
    {
        if ($this->isRouted)
        {
            return $this->isRouted;
        } elseif ($this->getParent())
        {
            return $this->getParent()->getIsRouted();
        }
        return $this->isRouted;
    }
    
    public function setIsActive($v)
    {
        $this->isActive = $v;
        return $this;
    }
    
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    public function setIsDisabled($v)
    {
        $this->isDisabled = $v;
        return $this;
    }
    
    public function getIsDisabled()
    {
        return $this->isDisabled;
    }
    
    public function addElement()
    {        
        $menuElement = new LlamaMenuElement();
        $menuElement->setMenu($this->getMenu());
        $menuElement->setParent($this);
        $menuElement->setLevel($this->getLevel() + 1);
        
        $this->elements[] = $menuElement;
        
        return $menuElement;
    }
    
    public function getElements()
    {
        return $this->elements;
    }
    
    public function addClass($class)
    {
        $this->classes[] = $class;
        return $this;
    }
    
    public function getClasses()
    {
        if ($this->getIsActive())
        {
            $this->addClass($this->getMenu()->getOption('activeClass'));
        } elseif ($this->getIsRouted()) {
            $this->addClass($this->getMenu()->getOption('routedClass'));
        }
        if ($this->getIsDisabled())
        {
            $this->addClass($this->getMenu()->getOption('disabledClass'));
        }
        return $this->classes;
    } 
}