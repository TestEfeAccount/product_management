<?php

namespace App\Exceptions;


use Exception;

class QuantityException extends Exception
{

    protected int $unavailableQuantity;

    /**
     * @return integer
     */
    public function getUnavailableQuantity()
    {
        return $this->unavailableQuantity;
    }


    public function __construct($unavailableQuantity, $message = null)
    {
        if (!$message) {
            $message = "Unavailable quantity :". $unavailableQuantity;
        }

        parent::__construct($message);
    }



}
