<?php
/**
 * File containing the Media class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Controller;

use BD\Bundle\WordpressAPIBundle\Service\Media as MediaService;
use BD\Bundle\XmlRpcBundle\XmlRpc\Response;
use Symfony\Component\HttpFoundation\Request;

class Media
{
    /** @var MediaService */
    protected $mediaService;

    public function __construct( MediaService $mediaService )
    {
        $this->mediaService = $mediaService;
    }

    public function getMediaItem( $mediaId, Request $request )
    {

    }

    public function getMediaLibrary( Request $request )
    {
        return new Response(
            $this->mediaService->getMediaList(
                $request->request->get( 'offset' ),
                $request->request->get( 'limit' )
            )
        );
    }

    public function uploadFile( Request $request )
    {

    }
}
