<?php declare(strict_types=1);

namespace Symfona\Pagination\Doctrine\MongoDB\AdapterBundle\Adapter;

use Doctrine\ODM\MongoDB\Iterator\Iterator;
use Symfona\Pagination\Adapter\AdapterInterface;
use Symfona\Pagination\Enum\Filter;
use Symfona\Pagination\Query;
use Symfona\Pagination\Result;

abstract class AbstractAdapter implements AdapterInterface
{
    private const OPERATORS_MAPPING = [
        Filter::EQUAL => '$eq',
        Filter::NOT_EQUAL => '$ne',
        Filter::IN => '$in',
        Filter::NOT_IN => '$nin',
        Filter::LESS_THEN => '$lt',
        Filter::LESS_THEN_OR_EQUAL => '$lte',
        Filter::GREATER_THEN => '$gt',
        Filter::GREATER_THEN_OR_EQUAL => '$gte',
        Filter::LIKE => '$regex',
        Filter::IS_NULL => '$exists',
        Filter::NOT_NULL => '$exists',
    ];

    public function getResult(Query $query): Result
    {
        $this->addFilters($query);

        if (0 === $count = $this->getCount()) {
            return new Result(0, []);
        }

        $this->addSorting($query);
        $this->addPagination($query);

        return new Result($count, $this->getItems());
    }

    protected function getOperator(string $name): string
    {
        return self::OPERATORS_MAPPING[$name];
    }

    abstract protected function addFilters(Query $query): void;

    abstract protected function addSorting(Query $query): void;

    abstract protected function addPagination(Query $query): void;

    abstract protected function getCount(): int;

    abstract protected function getItems(): Iterator;
}
