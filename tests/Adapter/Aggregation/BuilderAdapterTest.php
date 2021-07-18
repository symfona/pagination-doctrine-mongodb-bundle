<?php declare(strict_types=1);

namespace Symfona\Pagination\Doctrine\MongoDB\AdapterBundle\Tests\Adapter\Aggregation;

use Doctrine\ODM\MongoDB\Aggregation\Builder;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfona\Pagination\Doctrine\MongoDB\AdapterBundle\Tests\App\Document\Product;
use Symfona\Pagination\Enum\Filter;
use Symfona\Pagination\Enum\Sort;
use Symfona\Pagination\Paginator;
use Symfona\Pagination\Query;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BuilderAdapterTest extends KernelTestCase
{
    public static function setUpBeforeClass(): void
    {
        self::getDocumentManager()->createQueryBuilder()->remove(Product::class)->getQuery()->execute();

        foreach (\range(1, 100) as $i) {
            self::getDocumentManager()->persist(new Product(\sprintf('product_%d', $i)));
        }

        self::getDocumentManager()->flush();
    }

    public function testEmptyResult(): void
    {
        $query = new Query(
            filters: ['name' => [Filter::EQUAL => 'product_101']],
        );

        $result = self::getPaginator()->paginate(self::getAggregationBuilder(), $query);

        self::assertEmpty($result->count);
        self::assertEmpty($result->items);
    }

    public function testPaginator(): void
    {
        $query = new Query(
            filters: ['name' => [Filter::GREATER_THEN_OR_EQUAL => 'product_90']],
            sorting: ['name' => Sort::DESC],
            skip: 5,
            limit: 3,
        );

        $result = self::getPaginator()->paginate(self::getAggregationBuilder(), $query);

        self::assertSame(10, $result->count);

        $expected = ['product_94', 'product_93', 'product_92'];

        foreach ($result->items as $i => $product) {
            self::assertSame($expected[$i], $product['name']);
        }
    }

    private static function getPaginator(): Paginator
    {
        return self::getContainer()->get(Paginator::class); // @phpstan-ignore-line
    }

    private static function getDocumentManager(): DocumentManager
    {
        return self::getContainer()->get(DocumentManager::class); // @phpstan-ignore-line
    }

    private static function getAggregationBuilder(): Builder
    {
        return self::getDocumentManager()->createAggregationBuilder(Product::class);
    }
}
