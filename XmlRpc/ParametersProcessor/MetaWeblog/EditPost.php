<?php
/**
 * File containing the GetUserInfo class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\XmlRpc\ParametersProcessor\MetaWeblog;

use BD\Bundle\XmlRpcBundle\XmlRpc\ParametersProcessorInterface;

class EditPost extends NewPost
{
    public function getRoutePathArguments( $parameters )
    {
        return array( $parameters[0] );
    }
}
