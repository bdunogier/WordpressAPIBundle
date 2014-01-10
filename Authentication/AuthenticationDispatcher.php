<?php
/**
 * File containing the AuthenticationDispatcher class.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Authentication;

class AuthenticationDispatcher
{
    /** @var AuthenticationHandlerInterface[] */
    protected $authenticationHandlers;

    public function __construct( array $authenticationHandlers = array() )
    {
        $this->authenticationHandlers = $authenticationHandlers;
    }

    public function login( $username, $password )
    {
        foreach ( $this->authenticationHandlers as $authenticationHandler )
        {
            $authenticationHandler->login( $username, $password );
        }
    }
}
 