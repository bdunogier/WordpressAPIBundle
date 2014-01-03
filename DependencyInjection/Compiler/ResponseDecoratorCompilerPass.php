<?php
namespace BD\Bundle\WordpressAPIBundle\DependencyInjection\Compiler;

use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiled the DI tag bd_wordpress_api.response_decorator
 */
class ResponseDecoratorCompilerPass implements CompilerPassInterface
{
    public function process( ContainerBuilder $container )
    {
        if ( !$container->hasDefinition( 'bd_wordpress_api.response_decorator.dispatcher' ) )
        {
            return;
        }

        $dispatcherDefinition = $container->getDefinition( 'bd_wordpress_api.response_decorator.dispatcher' );

        $providers = array();
        $taggedServices = $container->findTaggedServiceIds( 'bd_wordpress_api.response_decorator' );
        foreach ( $taggedServices as $taggedServiceId => $tagAttributes )
        {
            foreach ( $tagAttributes as $attribute )
            {
                if ( !isset( $attribute['methodName'] ) )
                {
                    throw new InvalidArgumentException(
                        "Missing mandatory attribute 'methodName' for tag bd_wordpress_api.response_decorator"
                    );
                }
                $providers[$attribute['methodName']] = new Reference( $taggedServiceId );
            }
        }

        if ( count( $providers ) > 0 )
        {
            $dispatcherDefinition->setArguments( array( $providers ) );
        }
    }

}
