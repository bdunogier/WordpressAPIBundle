<?php
namespace BD\Bundle\WordpressAPIBundle\XmlRpc\ParametersProcessor\Wordpress;

use BD\Bundle\XmlRpcBundle\XmlRpc\ParametersProcessorInterface;

class GetPost implements ParametersProcessorInterface
{
    public function getRoutePathArguments( $parameters )
    {
        return array( $parameters[3] );
    }

    public function getParameters( $parameters )
    {
        return array(
            'appkey'   => $parameters[0],
            'username' => $parameters[1],
            'password' => $parameters[2],
        );
    }
}
