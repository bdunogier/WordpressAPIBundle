<?php
/**
 * File containing the Post class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Service;


interface PostServiceInterface
{
    /**
     * Creates a new post
     * @param array $content Post content. Keys: post_title, post_content,
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException If a category isn't found
     * @return int the created post ID
     */
    public function createPost( array $content );

    /**
     * @param int $limit
     * @return array
     */
    public function findRecentPosts( $limit = 5 );

    /**
     * Deletes the post with ID $postId
     * @param int $postId
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
    public function deletePost( $postId );

    /**
     * Retrieves the post with ID $postId
     * @param int $postId
     * @return array
     */
    public function getPost( $postId );

    /**
     * Edits the post with ID $postId
     * @param int $postId
     * @param array $content
     * @return array
     */
    public function editPost( $postId, array $content );
}
