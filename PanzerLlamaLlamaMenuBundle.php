<?php
namespace PanzerLlama\LlamaMenuBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use PanzerLlama\LlamaMenuBundle\DependencyInjection\PanzerLlamaLlamaMenuExtension;

class PanzerLlamaLlamaMenuBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new PanzerLlamaLlamaMenuExtension();
    }
}