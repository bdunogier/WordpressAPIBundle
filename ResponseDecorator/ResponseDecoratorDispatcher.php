<?php
/**
 * File containing the Dispatcher class.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\ResponseDecorator;

class ResponseDecoratorDispatcher implements ResponseDecoratorDispatcherInterface
{
    /** @var ResponseDecoratorInterface[] */
    protected $decorators;

    public function __construct( array $decorators = array() )
    {
        $this->decorators = $decorators;
    }

    /**
     */
    public function decorate( array $data, $methodName )
    {
        if ( isset( $this->decorators[$methodName] ) )
        {
            return $this->decorators[$methodName]->decorate( $data );
        }
        else
        {
            return $data;
        }
    }
}
