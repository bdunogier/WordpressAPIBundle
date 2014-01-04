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

class NewPost implements ParametersProcessorInterface
{
    public function getRoutePathArguments( $parameters )
    {
        return array();
    }

    public function getParameters( $parameters )
    {
        $postStatus = 'publish';
        if ( isset( $parameters[4] ) && $parameters[4] === false )
        {
            $postStatus = 'draft';
        }

        return array(
            'blogId' => $parameters[0],
            'username' => $parameters[1],
            'password' => $parameters[2],
            'content' => array(
                'post_title' => $parameters[3]['title'],
                'post_content' => $parameters[3]['description'],
                'post_type' => isset( $parameters[3]['post_type'] ) ? $parameters[3]['post_type'] : 'post',
                'post_date' => isset( $parameters[3]['dateCreated'] ) ? $parameters[3]['dateCreated'] : null,
                'post_date_gmt' => isset( $parameters[3]['date_created_gmt'] ) ? $parameters[3]['date_created_gmt'] : null,
                'post_author' => isset( $parameters[3]['wp_author_id'] ) ? $parameters[3]['wp_author_id'] : null,
                'post_status' => $postStatus,
                'categories' => isset( $parameters[3]['categories'] ) ? $parameters[3]['categories'] : array()
            )
        );
    }
}
