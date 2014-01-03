<?php
/**
 * File containing the GetPost class.
 *
 * @copyright Copyright (C) 2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\ResponseDecorator\Blogger;

use BD\Bundle\WordpressAPIBundle\ResponseDecorator\ResponseDecoratorInterface;

class GetPost implements ResponseDecoratorInterface
{
    public function decorate( array $data )
    {
        return array(
            'postid' => $data['post_id'],
            'userid' => $data['post_author'],
            'dateCreated' => $data['post_date'],
            'content' => $data['post_content']
        );
    }
}
