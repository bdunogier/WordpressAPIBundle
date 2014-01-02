<?php
/**
 * File containing the Media class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Service;

interface MediaServiceInterface
{
    public function getMedia( $id );

    /**
     * Returns media library items
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getMediaList( $offset, $limit );

    /**
     * Creates an image file
     * @param string $name Image name
     * @param string $contents Image file contents
     * @param bool $overwrite
     * @param int $contentId
     * @return array An array with the following keys: id, file, url and type
     */
    public function createImage( $name, $contents, $overwrite, $contentId = 0 );
}
