<?php

namespace Domain\Fixtures\Repository;

use Domain\Aggregates\BaseAggregateRepository;
use Domain\Fixtures\Aggregates\Basket;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
final class BasketRepository extends BaseAggregateRepository
{
    protected function getAggregateRootFqcn()
    {
        return Basket::class;
    }
}
