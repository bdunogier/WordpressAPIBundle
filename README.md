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

## Supported XML-RPC methods

## References
- Blogger API: http://codex.wordpress.org/XML-RPC_Blogger_API
- MovableType API: http://codex.wordpress.org/XML-RPC_MovableType_API
- MetaWeblog API: http://codex.wordpress.org/XML-RPC_MetaWeblog_API
- Wordpress API: http://codex.wordpress.org/XML-RPC_WordPress_API

