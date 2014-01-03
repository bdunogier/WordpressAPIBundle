<?php
namespace BD\Bundle\WordpressAPIBundle\ResponseDecorator\MetaWeblog;

use BD\Bundle\WordpressAPIBundle\ResponseDecorator\ResponseDecoratorInterface;

class GetRecentPosts implements ResponseDecoratorInterface
{
    /** @var ResponseDecoratorInterface */
    private $postDecorator;

    public function __construct( ResponseDecoratorInterface $postDecorator )
    {
        $this->postDecorator = $postDecorator;
    }

    public function decorate( array $data )
    {
        $postDecorator = $this->postDecorator;

        return array_map(
            function ( $post ) use ( $postDecorator )
            {
                return $postDecorator->decorate( $post );
            },
            $data
        );
    }
}
