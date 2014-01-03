<?php
namespace BD\Bundle\WordpressAPIBundle\ResponseDecorator\MetaWeblog;

use BD\Bundle\WordpressAPIBundle\ResponseDecorator\ResponseDecoratorInterface;

class GetPost implements ResponseDecoratorInterface
{
    public function decorate( array $data )
    {
        $keywords = array_map(
            function ( $item )
            {
                return $item['name'];
            },
            $data['terms']
        );

        return array(
            'postid' => $data['post_id'],
            'title' => $data['post_title'],
            'description' => $data['post_content'],
            'link' => $data['link'],
            'userid' => $data['post_author'],
            'dateCreated' => $data['post_date'],
            'date_created_gmt' => $data['post_date_gmt'],
            'date_modified' => $data['post_modified'],
            'date_modified_gmt' => $data['post_modified_gmt'],
            'wp_post_thumbnail' => $data['post_thumbnail']['thumbnail'],
            'permaLink' => $data['link'],
            'categories' => array(), // @todo not returned by Wordpress
            'mt_keywords' => $keywords,
            'mt_excerpt' => $data['post_excerpt'],
            'mt_text_more' => '',
            'wp_more_text' => '',
            'mt_allow_comments' => (int)( $data['comment_status'] == 'open' ),
            'mt_allow_pings' => (int)( $data['ping_status'] == 'open' ),
            'wp_slug' => $data['post_name'],
            'wp_password' => $data['post_password'],
            'wp_author_id' => $data['post_author'],
            'wp_author_display_name' => '',
            'post_status' => $data['post_status'],
            'wp_post_format' => '',
            'sticky' => (int)$data['sticky']
        );
    }
}
