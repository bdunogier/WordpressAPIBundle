<?php
/**
 * File containing the Post class.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Controller;

use BD\Bundle\WordpressAPIBundle\Service\PostServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use BD\Bundle\XmlRpcBundle\XmlRpc\Response;

class Post
{
    /** @var PostServiceInterface */
    protected $postService;

    public function __construct( PostServiceInterface $postService )
    {
        $this->postService = $postService;
    }

    public function deletePost( $postId )
    {
        $this->postService->deletePost( $postId );
        return new Response( true );
    }
}
