<?php

namespace AppBundle\Service;

use AppBundle\Entity\Game;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * Game namer - Service
 *
 */
class GameImageNamer implements NamerInterface{

    public function name($object, PropertyMapping $mapping)
    {
        /** @var Game $object **/
        $prefix = $object->getShortDomainName();

        $file = $mapping->getFile($object);

        $newName = $prefix.'_'.uniqid();

        if ($extension = $file->guessExtension())
        {
            $newName = $newName.'.'.$extension;
        }

        return $newName;
    }
}