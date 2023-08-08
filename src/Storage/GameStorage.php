<?php

namespace src\Storage;

use ReturnTypeWillChange;
use SplObjectStorage;

class GameStorage extends SplObjectStorage
{
    /**
     * We need to override the getHash method because by default it uses the spl_object_hash() function
     * which returns a unique identifier for the object. This is not what we want because we want to
     * compare the objects by their properties.
     */
    #[ReturnTypeWillChange] public function getHash($obj)
    {
        return $obj->id;
    }
}
