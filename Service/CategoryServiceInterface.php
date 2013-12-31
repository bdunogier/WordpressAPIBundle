<?php
/**
 * File containing the Category class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Service;

interface CategoryServiceInterface
{
    /**
     * Returns the categories list
     * @return array array of hashes. Hash keys: categoryId, categoryName
     */
    public function getList();

    /**
     * Returns the categories of a post
     * @param mixed $post
     * @return array Returns the categories of a content
     */
    public function getPostCategories( $postId );
}
