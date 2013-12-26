<?php
/**
 * File containing the Options class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use BD\Bundle\XmlRpcBundle\XmlRpc\Response;

class Options
{
    public function getOptions( Request $request )
    {
        $return = array();
        foreach ( $request->request->get( 'options' ) as $option )
        {
            $return[] = $this->getOption( $option );
        }

        return new Response( $return );
    }

    protected function getOption( $optionName )
    {
        $options = array();
        switch ( $optionName )
        {
            case 'software_version':
                $options = array(
                    'desc' => 'Software version',
                    'readonly' => true,
                    'value' => "3.4"
                );
                break;

            case 'home_url':
                $options = array(
                    'desc' => 'Home URL',
                    'readonly' => true,
                    'value' => "http://localhost/"
                );
                break;

            case 'login_url':
                $options = array(
                    'desc' => 'Login URL',
                    'readonly' => true,
                    'value' => "http://localhost/user/login"
                );
                break;

            case 'admin_url':
                $options = array(
                    'desc' => 'Admin URL',
                    'readonly' => true,
                    'value' => "http://localhost/wp_back/"
                );
                break;
        }

        return array( $optionName => $options );
    }
}
