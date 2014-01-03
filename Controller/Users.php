<?php
/**
 * File containing the Users class.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Controller;

use BD\Bundle\XmlRpcBundle\XmlRpc\Response;

class Users
{
    public function getUsersBlogs()
    {
        return new Response(
            array(
                array(
                    'isAdmin' => 1,
                    'url' => 'http://localhost:88/',
                    'blogid' => 1,
                    'blogName' => 'eZ Wordpress',
                    'xmlrpc' => 'http://localhost:88/xmlrpc.php'
                )
            )
        );
    }
}
