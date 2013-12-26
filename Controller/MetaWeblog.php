<?php
/**
 * File containing the MetaWeblog class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Controller;

use eZ\Publish\API\Repository\Repository;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Content;
use Symfony\Component\HttpFoundation\Request;
use BD\Bundle\XmlRpcBundle\XmlRpc\Response;
use eZ\Publish\API\Repository\Values\Content\Query;

class MetaWeblog
{
    /** @var Repository */
    protected $repository;

    /** @var SearchService */
    protected $searchService;

    public function __construct( Repository $repository )
    {
        $this->repository = $repository;
        $this->searchService = $repository->getSearchService();
    }
    public function getRecentPosts( Request $request )
    {
        $query = new Query();
        $query->criterion = new Query\Criterion\ContentTypeIdentifier( 'blog_post' );
        $query->limit = $request->request->has( 'limit' ) ? $request->request->get( 'limit' ) : 5;

        $results = $this->searchService->findContent( $query );
        $recentPosts = array();
        foreach ( $results->searchHits as $searchHit )
        {
            /** @var \eZ\Publish\Core\Repository\Values\Content\Content $content */
            $recentPosts[] = $this->serializeContentAsPost( $searchHit->valueObject );
        }

        return new Response( $recentPosts );
    }

    protected function serializeContentAsPost( Content $content )
    {
        return array(
            'dateCreated' => $content->versionInfo->creationDate,
            'userid' => $content->contentInfo->ownerId,
            'postid' => $content->id,
            'description' => 'Dummy desc',
            'title' => (string)$content->fields['title']['eng-GB'],
            'link' => 'http://vm:88/',
            'permaLink' => 'http://vm:88/',
            'categories' => array( 'uncategorized' ),
            'mt_excerpt' => '',
            'mt_text_more' => '',
            'wp_more_text' => '',
            'mt_allow_comments' => 0,
            'mt_allow_pings' => 1,
            'mt_keywords' => '',
            'wp_slug' => 'slug',
            'wp_password' => '',
            'wp_author_id' => $content->contentInfo->ownerId,
            'wp_author_display_name' => 'admin',
            'date_created_gmt' => $content->versionInfo->creationDate,
            'post_status' => 'publish',
            'custom_fields' => array(),
            'wp_post_format' => 'standard',
            'date_modified' => $content->versionInfo->modificationDate,
            'date_modified_gmt' => $content->versionInfo->modificationDate,
            'wp_post_thumbnail' => ''
        );
    }
}
