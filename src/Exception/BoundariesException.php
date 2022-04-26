<?php

namespace App\Exception;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Triggered when Rover try to move beyond plateau Boundaries.
 */
class BoundariesException extends RuntimeException
{
    public function __construct() {
        parent::__construct("You can not move the rover beyond the plateau boundaries", Response::HTTP_BAD_REQUEST);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
