<?php
/**
 * File containing the ApiDecoratorInterface class.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\ResponseDecorator;

/**
 * Decorates a Wordpress response into one suitable for another platform
 */
interface ResponseDecoratorInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function decorate( array $data );
}
