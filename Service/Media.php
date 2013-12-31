<?php
/**
 * File containing the Media class.
 *
 * @copyright Copyright (C) 2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */
namespace BD\Bundle\WordpressAPIBundle\Service;

interface Media
{
    public function getMedia( $id );

    /**
     * Returns media library items
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getMediaList( $offset, $limit );

    public function uploadFile();
}
