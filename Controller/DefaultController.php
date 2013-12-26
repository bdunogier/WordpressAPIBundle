<?php

namespace BD\Bundle\WordpressAPIBundle\Controller;

use BD\Bundle\WordpressAPIBundle\Service\Category as CategoryService;
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\Repository;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\UserService;
use eZ\Publish\API\Repository\Values\Content\Content;
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

    /** @var Category */
    protected $categoryService;

    public function __construct( Repository $repository, CategoryService $categoryService )
    {
        $this->repository = $repository;
        $this->categoryService = $categoryService;

        $this->searchService = $repository->getSearchService();
        $this->contentService = $repository->getContentService();
        $this->locationService = $repository->getLocationService();
        $this->contentTypeService = $repository->getContentTypeService();
        $this->userService = $repository->getUserService();
    }

    public function getUsersBlogs()
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
        return new Response( $this->categoryService->getList() );
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
            $recentPosts[] = $this->serializeContentAsPost( $searchHit->valueObject );
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
        return new Response( $this->categoryService->getPostCategories( $postId ) );
    }

    public function editPost()
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

        return new Response( $this->serializeContentAsPost( $content ) );
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
                'metaWeblog.getCategories',
                'system.listMethods',
                'wp.getUsersBlogs',
                'wp.getOptions',
                'wp.getProfile'
            )
        );
    }

    public function getProfile( Request $request )
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

    public function getComments()
    {
        return new Response( array() );
    }

    public function getPostFormats()
    {
        return new Response(
            array(
                'standard' => 'Standard'
            )
        );
    }

    protected function serializeContentAsPost( Content $content )
    {
        return array(
            'post_id' => $content->id,
            'post_title' => (string)$content->fields['title']['eng-GB'],
            'post_date' => $content->versionInfo->creationDate,
            'description' => '',
            'link' => '',
            'userId' => $content->contentInfo->ownerId,
            'dateCreated' => $content->versionInfo->creationDate,
            'date_created_gmt' => $content->versionInfo->creationDate,
            'date_modified' => $content->versionInfo->modificationDate,
            'date_modified_gmt' => $content->versionInfo->modificationDate,
            'wp_post_thumbnail' => 0,
            'categories' => array(),
        );
    }

    private function login( $username, $password )
    {
        $this->repository->setCurrentUser(
            $this->userService->loadUserByCredentials( $username, $password )
        );
    }
}
