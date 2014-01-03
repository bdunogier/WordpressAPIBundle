<?php
/**
 * File containing the Dispatcher class.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\ResponseDecorator;

interface ResponseDecoratorDispatcherInterface
{
    /**
     * Dispatches a decorate() call on $data to the dispatcher for $methodName, if any
     *
     * @param array $data Data that needs decorating
     * @param string $methodName name of the method to decorate for
     *
     * @return array Decorated $data if there was a decorator, original $data otherwise
     */
    public function decorate( array $data, $methodName );
}
