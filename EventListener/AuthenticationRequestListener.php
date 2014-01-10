<?php
namespace BD\Bundle\WordpressAPIBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthenticationRequestListener
{
    protected $authenticationDispatcher;

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(
                // lower priority than the XmlRpcBundle Request Event Listener
                array( 'onKernelRequest', 32 ),
            )
        );
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest( GetResponseEvent $event )
    {
        $request = $event->request;
        if ( !$request->attributes->has( 'IsXmlRpcRequest' ) )
        {
            return;
        }

        if ( !$request->request->has( 'username' ) || !$request->request->has( 'password' ) )
        {
            return;
        }


    }
}
 