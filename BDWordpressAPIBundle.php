<?php

namespace BD\Bundle\WordpressAPIBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BDWordpressAPIBundle extends Bundle
{
    public function build( ContainerBuilder $container )
    {
        parent::build( $container );
        $container->addCompilerPass( new DependencyInjection\Compiler\ResponseDecoratorCompilerPass() );
        $container->addCompilerPass( new DependencyInjection\Compiler\AuthenticationHandlerCompilerPass() );
    }
}
