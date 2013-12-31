<?php
/**
 * File containing the GetOptions class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\XmlRpc\ParametersProcessor\Wordpress;

use BD\Bundle\XmlRpcBundle\XmlRpc\ParametersProcessorInterface;

class GetMediaItem implements ParametersProcessorInterface
{
    public function getRoutePathArguments( $parameters )
    {
        return array( $parameters[3] );
    }

    public function getParameters( $parameters )
    {
        return array(
            'blog_id' => $parameters[0],
            'username' => $parameters[1],
            'password' => $parameters[2]
        );
    }
}
