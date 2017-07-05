<?php

namespace AppBundle\Service;

use AppBundle\Entity\Artwork;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * Cover Image Namer - Service
 *
 */
class CoverImageNamer implements NamerInterface{

    public function name($object, PropertyMapping $mapping)
    {
        /** @var Artwork $object **/
        $prefix = $object->getName();

        $file = $mapping->getFile($object);

        $newName = $prefix.'_'.uniqid();

        if ($extension = $file->guessExtension())
        {
            $newName = $newName.'.'.$extension;
        }

        return $newName;
    }
}