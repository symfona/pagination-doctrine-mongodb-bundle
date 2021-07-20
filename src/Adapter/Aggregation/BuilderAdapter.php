<?php declare(strict_types=1);

namespace Symfona\Pagination\Doctrine\MongoDB\AdapterBundle\Adapter\Aggregation;

use Doctrine\ODM\MongoDB\Aggregation\Builder;
use Doctrine\ODM\MongoDB\Iterator\Iterator;
use Symfona\Pagination\Doctrine\MongoDB\AdapterBundle\Adapter\AbstractAdapter;
use Symfona\Pagination\Query;

final class BuilderAdapter extends AbstractAdapter
{
    private const OPTIONS = [
        'allowDiskUse' => true,
    ];

    public function __construct(private Builder $builder)
    {
    }

    protected function addFilters(Query $query): void
    {
        $match = $this->builder->match();

        foreach ($query->filters as $fieldName => $operators) {
            foreach ($operators as $operator => $value) {
                $match->addAnd($match->expr()->field($fieldName)->operator($this->getOperator($operator), $value));
            }
        }
    }

    protected function addSorting(Query $query): void
    {
        foreach ($query->sorting as $fieldName => $direction) {
            $this->builder->sort($fieldName, $direction);
        }
    }

    protected function addPagination(Query $query): void
    {
        if ($query->skip > 0) {
            $this->builder->skip($query->skip);
        }

        if ($query->limit > 0) {
            $this->builder->limit($query->limit);
        }
    }

    protected function getCount(): int
    {
        $builder = clone $this->builder;

        return (int) ($builder->count('count')->getAggregation(self::OPTIONS)->getIterator()->current()['count'] ?? 0);
    }

    protected function getItems(): Iterator
    {
        return $this->builder->getAggregation(self::OPTIONS)->getIterator();
    }
}
