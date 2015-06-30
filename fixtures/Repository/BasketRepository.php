<?php

namespace Domain\Tests\Fixtures\Repository;

use Domain\Aggregates\BaseAggregateRepository;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
final class BasketRepository extends BaseAggregateRepository
{
    protected function getAggregateRootFqcn()
    {
        return 'Domain\Tests\Fixtures\Aggregates\Basket';
    }
}