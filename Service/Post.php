<?php
/**
 * File containing the Post class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Service;


interface Post
{
    /**
     * Creates a new post
     * @param string $title
     * @param string $description
     * @param array $categories
     * @return int the created post ID
     */
    public function createPost( $title, $description, array $categories );

    /**
     * @param int $limit
     * @return array
     */
    public function findRecentPosts( $limit = 5 );
}
