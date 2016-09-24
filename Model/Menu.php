<?php
namespace PanzerLlama\Menu\Model;

class Menu {
        
    protected $elements;
    protected $options;
    protected $template;
    protected $activeClass  = 'active';
    protected $routedClass  = 'in-route';
    
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }
    
    public function setTemplate($v)
    {
        $this->template = $v;
        return $this;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function addElement()
    {
        $v = new LlamaMenuElement();
        $v->setMenu($this);
        $this->elements[] = $v;
        return $v;
    }
    
    public function getElements()
    {
        return $this->elements;
    }
    
    public function getActiveClass()
    {
        return $this->activeClass;
    }
    
    public function getRoutedClass()
    {
        return $this->routedClass;
    }
    
    public function getElementByLabel($label)
    {
        foreach ($this->getElements() as $e)
        {
            if (strcmp($e->getLabel(), $label) == 0)
            {
                return $e;
            }
        }
        return false;
    }
}