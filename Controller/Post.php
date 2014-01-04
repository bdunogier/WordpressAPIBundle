<?php
/**
 * File containing the Post class.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Controller;

use BD\Bundle\WordpressAPIBundle\ResponseDecorator\ResponseDecoratorDispatcherInterface;
use BD\Bundle\WordpressAPIBundle\Service\PostServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use BD\Bundle\XmlRpcBundle\XmlRpc\Response;

class Post
{
    /** @var PostServiceInterface */
    protected $postService;

    /** @var ResponseDecoratorDispatcherInterface */
    private $responseDecoratorDispatcher;

    public function __construct( PostServiceInterface $postService, ResponseDecoratorDispatcherInterface $dispatcher )
    {
        $this->postService = $postService;
        $this->responseDecoratorDispatcher = $dispatcher;
    }

    public function deletePost( $postId )
    {
        $this->postService->deletePost( $postId );
        return new Response( true );
    }

    public function getRecentPosts( Request $request )
    {
        $posts = $this->postService->findRecentPosts(
            $request->request->has( 'limit' ) ? $request->request->get( 'limit' ) : 5
        );

        return new Response(
            $this->responseDecoratorDispatcher->decorate(
                $posts,
                $request->attributes->get( 'xmlrpc_methodName' )
            )
        );
    }

    public function editPost( $postId, Request $request)
    {
        return new Response(
            $this->postService->editPost( $postId, $request->request->get( 'content' ) )
        );
    }

    public function getPost( $postId, Request $request )
    {
        return new Response(
            $this->responseDecoratorDispatcher->decorate(
                $this->postService->getPost( $postId ),
                $request->attributes->get( 'xmlrpc_methodName' )
            )
        );
    }

    public function newPost( Request $request )
    {
        $postData = $request->request->get( 'content' );

        return new Response(
            $this->postService->createPost(
                $postData['post_title'],
                $postData['post_content'],
                $postData['categories']
            )
        );
    }
}
