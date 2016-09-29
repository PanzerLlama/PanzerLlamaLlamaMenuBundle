<?php
namespace PanzerLlama\LlamaMenuBundle\Menu;

use PanzerLlama\Menu\Model\LlamaMenu;

class DefaultMenu extends LlamaMenu
{
    public function __construct(array $options)
    {
        parent::__construct($options);
        
        $this->addElement()
            ->setName('Dashboard')
            ->setIcon('fa-tachometer')
            ->setLabel('dashboard')
            ->addRoute('admin_dashboard');
        
        $this->addElement()
            ->setName('Categories')
            ->setIcon('fa-sitemap')
            ->setLabel('admin-category')
            ->addRoute('admin_category')
            ->addInRoute('admin_category_edit')
            ->addInRoute('admin_category_edit_images')
            ->addInRoute('admin_category_move')
            ->addElement()
            ->setName('Create Category')
            ->setIcon('fa-sitemap')
            ->setSubIcon('fa-plus-circle')
            ->addRoute('admin_category_create');
        
        $this->addElement()
            ->setName('Users')
            ->setIcon('fa-users')
            ->setLabel('admin-user')
            ->addRoute('admin_user');        
    }
}