<?php

namespace BD\Bundle\WordpressAPIBundle\Controller;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\Repository;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\UserService;
use eZ\Publish\API\Repository\Values\Content\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BD\Bundle\XmlRpcBundle\XmlRpc\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController
{
    /** @var Repository */
    protected $repository;

    /** @var SearchService */
    protected $searchService;

    /** @var ContentService */
    protected $contentService;

    /** @var LocationService */
    protected $locationService;

    /** @var ContentTypeService */
    protected $contentTypeService;

    /** @var UserService */
    protected $userService;

    public function __construct( Repository $repository )
    {
        $this->repository = $repository;
        $this->searchService = $repository->getSearchService();
        $this->contentService = $repository->getContentService();
        $this->locationService = $repository->getLocationService();
        $this->contentTypeService = $repository->getContentTypeService();
        $this->userService = $repository->getUserService();
    }

    public function getUsersBlogAction()
    {
        return new Response(
            array(
                array(
                    'isAdmin' => 1,
                    'url' => 'http://localhost:88/',
                    'blogid' => 1,
                    'blogName' => 'eZ Wordpress',
                    'xmlrpc' => 'http://localhost:88/xmlrpc.php'
                )
            )
        );
    }

    public function getCategoryList()
    {
        return new Response(
            array(
                array(
                    'categoryId' => 333,
                    'categoryName' => 'General'
                ),
                array(
                    'categoryId' => 334,
                    'categoryName' => 'XML-RPC'
                ),
                array(
                    'categoryId' => 336,
                    'categoryName' => 'Testing'
                )
            )
        );
    }

    public function getRecentPosts()
    {
        $query = new Query();
        $query->criterion = new Query\Criterion\ContentTypeIdentifier( 'blog_post' );
        $query->limit = 5;

        $results = $this->searchService->findContent( $query );
        $recentPosts = array();
        foreach ( $results->searchHits as $searchHit )
        {
            /** @var \eZ\Publish\Core\Repository\Values\Content\Content $content */
            $content = $searchHit->valueObject;
            $recentPosts[] = array(
                'postid' => $content->id,
                'title' => $content->contentInfo->name,
                'dateCreated' => 0,
                'date_created_gmt' => 0,
                'post_status' => 0,
            );
        }

        return new Response( $recentPosts );
    }

    public function newPost( Request $request )
    {
        $this->login( $request->request->get( 'username' ), $request->request->get( 'password' ) );

        $createStruct = $this->contentService->newContentCreateStruct(
            $this->contentTypeService->loadContentTypeByIdentifier( 'blog_post' ),
            'eng-GB'
        );
        $postData = $request->request->get( 'content' );
        $createStruct->setField( 'title', $postData['title'] );

        $draft = $this->contentService->createContent(
            $createStruct,
            array( $this->locationService->newLocationCreateStruct( 2 ) )
        );

        $content = $this->contentService->publishVersion( $draft->versionInfo );

        return new Response( $content->id );
    }

    public function setPostCategories( $postId, Request $request )
    {
        $this->login( $request->request->get( 'username' ), $request->request->get( 'password' ) );

        // @todo Replace categories instead of adding
        $contentInfo = $this->contentService->loadContentInfo( $postId );
        foreach ( $request->request->get( 'categories' ) as $category )
        {
            $this->locationService->createLocation(
                $contentInfo,
                $this->locationService->newLocationCreateStruct( $category['categoryId'] )
            );
        }
        return new Response( true );
    }

    public function getPostCategories( $postId )
    {
        $contentInfo = $this->contentService->loadContentInfo( $postId );
        $locations = $this->locationService->loadLocations( $contentInfo );

        $categories = array();
        foreach ( $locations as $location )
        {
            $parent = $this->locationService->loadLocation( $location->parentLocationId );
            $categories[] = array(
                'categoryId' => $parent->id,
                'categoryName' => $parent->contentInfo->name,
                'isPrimary' => ( $location->id === $contentInfo->mainLocationId ),
                'parentId' => $parent->parentLocationId,
                'htmlUrl' => '',
                'rssurl' => '',
            );
        }

        return new Response( $categories );
    }

    public function editPost( Request $request )
    {
        return new Response( true );
    }

    public function deletePost( $postId, Request $request )
    {
        $this->login( $request->request->get( 'username' ), $request->request->get( 'password' ) );
        $this->contentService->deleteContent(
            $this->contentService->loadContentInfo( $postId )
        );
        return new Response( true );
    }

    public function getPost( $postId )
    {
        $content = $this->contentService->loadContent( $postId );

        return new Response(
            array(
                'postid' => $content->id,
                'title' => (string)$content->fields['title']['eng-GB'],
                'description' => '',
                'link' => '',
                'userId' => $content->contentInfo->ownerId,
                'dateCreated' => 0,
                'date_created_gmt' => 0,
                'date_modified' => 0,
                'date_modified_gmt' => 0,
                'wp_post_thumbnail' => 0,
                'categories' => array(),
            )
        );
    }

    public function getSupportedMethods()
    {
        return new Response(
            array(
                'blogger.getUsersBlogs',
                'mt.getRecentPostTitles',
                'mt.getCategoryList',
                'mt.setPostCategories',
                'mt.getPostCategories',
                'mt.supportedMethods',
                'metaWeblog.getCategories',
                'metaWeblog.getRecentPosts',
                'metaWeblog.newPost',
                'metaWeblog.editpost',
                'metaWeblog.deletePost',
                'metaWeblog.getPost',
                'metaWeblog.getCategories'
            )
        );
    }

    public function getUserInfo( Request $request )
    {
        $user = $this->userService->loadUserByCredentials(
            $request->request->get( 'username' ),
            $request->request->get( 'password' )
        );

        return new Response(
            array(
                'userid' => $user->contentInfo->id,
                'nickname' => $user->contentInfo->name,
                'firstname' => (string)$user->getFieldValue( 'first_name' ),
                'lastname' => (string)$user->getFieldValue( 'last_name' ),
                'url' => '',
            )
        );
    }

    private function login( $username, $password )
    {
        $this->repository->setCurrentUser(
            $this->userService->loadUserByCredentials( $username, $password )
        );
    }
}
