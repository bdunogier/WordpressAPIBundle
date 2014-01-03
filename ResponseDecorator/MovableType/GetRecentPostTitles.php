<?php
namespace BD\Bundle\WordpressAPIBundle\ResponseDecorator\MovableType;

use BD\Bundle\WordpressAPIBundle\ResponseDecorator\ResponseDecoratorInterface;

class GetRecentPostTitles implements ResponseDecoratorInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function decorate( array $data )
    {
        $posts = array();
        foreach ( $data as $post )
        {
            $posts[] = array(
                'postid' => $post['post_id'],
                'userid' => $post['post_author'],
                'title' => $post['post_title'],
                'dateCreated' => $post['post_date'],
                'date_created_gmt' => $post['post_date_gmt'],
                'post_status' => $post['post_status']
            );
        }

        return $posts;
    }
}
