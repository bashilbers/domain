<?php

namespace Domain\Events\Store\Features;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
interface HasTransactionCapabilities
{
    public function beginTransaction();

    public function commit();

    public function rollback();
}