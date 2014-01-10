<?php
namespace BD\Bundle\WordpressAPIBundle\DependencyInjection\Compiler;

use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiled the DI tag bd_wordpress_api.authentication_handler
 */
class AuthenticationHandlerCompilerPass implements CompilerPassInterface
{
    public function process( ContainerBuilder $container )
    {
        if ( !$container->hasDefinition( 'bd_wordpress_api.authentication_dispatcher' ) )
        {
            return;
        }

        $dispatcherDefinition = $container->getDefinition( 'bd_wordpress_api.authentication_dispatcher' );

        $handlers = array();
        $taggedServices = $container->findTaggedServiceIds( 'bd_wordpress_api.authentication_handler' );
        foreach ( $taggedServices as $taggedServiceId => $tagAttributes )
        {
            $handlers[] = new Reference( $taggedServiceId );
        }

        if ( count( $handlers ) > 0 )
        {
            $dispatcherDefinition->setArguments( array( $handlers ) );
        }
    }

}
