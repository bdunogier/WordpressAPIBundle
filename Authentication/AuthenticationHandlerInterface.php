<?php
/**
 * File containing the AuthenticationHandlerInterface interface.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Authentication;


interface AuthenticationHandlerInterface
{
    public function login( $username, $password );
} 