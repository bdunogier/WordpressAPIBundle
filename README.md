# Wordpress API Bundle

This Symfony 2 bundle implements convenient bridges from the various Wordpress XML-RPC APIs (blogger, MovableType,
MetaWeblog).

## Installation

Add bdunogier/wordpressapibundle to your composer.json, and run composer update/install.

## Dependencies

- https://github.com/bdunogier/xmlrpcbundle.
- http://github.com/ezsystems/ezpublish-kernel (temporary requirement)
  since it is initially based on the eZ Publish 5 content API. This requirement will be removed in the near future
  by means of handlers, and the eZPublish specifics moved to a dedicated bundle.

## Support status
At this time, this bundle supports the following API methods:

- blogger.getUsersBlogs
- blogger.getUserInfo
- blogger.getPost
- blogger.deletePost
- mt.getRecentPostTitles
- mt.getCategoryList
- mt.setPostCategories
- mt.getPostCategories
- mt.supportedMethods
- metaWeblog.getCategories
- metaWeblog.getRecentPosts
- metaWeblog.newPost
- metaWeblog.editPost
- metaWeblog.deletePost
- metaWeblog.getPost
- metaWeblog.getCategories
- system.listMethods
- wp.getUsersBlogs
- wp.getOptions
- wp.getProfile
- wp.getComments
- wp.getPostFormats
- wp.uploadFile
- wp.getMediaLibrary
- wp.getMediaItem
- wp.deletePost
- wp.getPost

Some of them have hardcoded values, other return empty values...

The Android Wordpress app (https://github.com/wordpress-mobile/WordPress-Android) will list posts, allow creation and
removal of existing posts.

## References
- Blogger API: http://codex.wordpress.org/XML-RPC_Blogger_API
- MovableType API: http://codex.wordpress.org/XML-RPC_MovableType_API
- MetaWeblog API: http://codex.wordpress.org/XML-RPC_MetaWeblog_API
- Wordpress API: http://codex.wordpress.org/XML-RPC_WordPress_API

[![Analytics](https://ga-beacon.appspot.com/UA-52121860-1/WordpressAPIBundle/readme)](https://github.com/igrigorik/ga-beacon)
