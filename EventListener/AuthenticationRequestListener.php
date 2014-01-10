<?php
namespace BD\Bundle\WordpressAPIBundle\EventListener;

use BD\Bundle\WordpressAPIBundle\Authentication\AuthenticationDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthenticationRequestListener implements EventSubscriberInterface
{
    /** @var AuthenticationDispatcher */
    protected $authenticationDispatcher;

    public function __construct( AuthenticationDispatcher $authenticationDispatcher )
    {
        $this->authenticationDispatcher = $authenticationDispatcher;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(
                // lower priority than the XmlRpcBundle Request Event Listener
                array( 'onKernelRequest', 0 ),
            )
        );
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest( GetResponseEvent $event )
    {
        $request = $event->getRequest();
        if ( !$request->attributes->has( 'IsXmlRpcRequest' ) )
        {
            return;
        }

        if ( !$request->request->has( 'username' ) || !$request->request->has( 'password' ) )
        {
            return;
        }

        $this->authenticationDispatcher->login(
            $request->request->get( 'username' ),
            $request->request->get( 'password' )
        );
    }
}
 