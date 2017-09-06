<?php
namespace PanzerLlama\LlamaMenuBundle\Model;

class LlamaMenu
{        
    protected $elements = array();
    protected $options  = array();
    
    public function __construct(array $options = array())
    {
        $this->setOptions($options);
    }
   
    public function setOptions($options)
    {
        $this->options = array_replace_recursive(
            array(
                'template'      => 'PanzerLlamaLlamaMenuBundle:Default:SideMenu.html.twig',
                'activeClass'   => 'active',
                'routedClass'   => 'routed',
                'disabledClass' => 'disabled'
            ),
            $options
        );
        return $this;
    }
    
    public function getOptions()
    {
        return $this->options;
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }
    
    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
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