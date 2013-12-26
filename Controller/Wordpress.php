<?php
/**
 * File containing the Wordpress class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Controller;

use BD\Bundle\EzWordpressAPIBundle\WordpressAPI\CategoryService;
use BD\Bundle\XmlRpcBundle\XmlRpc\Response;

class Wordpress
{
    public function __construct( CategoryService $categoryService )
    {
        $this->categoryService = $categoryService;
    }

    public function getCategories()
    {
        return new Response( $this->categoryService->getList() );
    }
}
