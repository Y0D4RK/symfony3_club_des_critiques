<?php

namespace UserBundle\Service;

use UserBundle\Entity\User;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * Avatar Image Namer - Service
 *
 */
class AvatarImageNamer implements NamerInterface{

    public function name($object, PropertyMapping $mapping)
    {
        /** @var User $object **/
        $prefix = $object->getUsernameCanonical();

        $file = $mapping->getFile($object);

        $newName = $prefix.'_'.uniqid();

        if ($extension = $file->guessExtension())
        {
            $newName = $newName.'.'.$extension;
        }

        return $newName;
    }
}