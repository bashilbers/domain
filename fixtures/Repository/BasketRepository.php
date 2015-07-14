<?php

namespace Domain\Fixtures\Repository;

use Domain\Aggregates\BaseAggregateRepository;
use Domain\Fixtures\Aggregates\Basket;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
final class BasketRepository extends BaseAggregateRepository
{
    protected function getAggregateRootFqcn()
    {
        return Basket::class;
    }
}
