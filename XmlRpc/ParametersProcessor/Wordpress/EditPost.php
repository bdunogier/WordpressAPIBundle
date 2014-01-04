<?php
namespace BD\Bundle\WordpressAPIBundle\XmlRpc\ParametersProcessor\Wordpress;

use BD\Bundle\XmlRpcBundle\XmlRpc\ParametersProcessorInterface;

class EditPost implements ParametersProcessorInterface
{
    public function getRoutePathArguments( $parameters )
    {
        return array( $parameters[3] );
    }

    public function getParameters( $parameters )
    {
        return array(
            'blogid' => $parameters[0],
            'username' => $parameters[1],
            'password' => $parameters[2],
            'content' => $parameters[4]
        );
    }
}
