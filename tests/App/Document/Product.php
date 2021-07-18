<?php declare(strict_types=1);

namespace Symfona\Pagination\Doctrine\MongoDB\AdapterBundle\Tests\App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
final class Product
{
    /**
     * @MongoDB\Id
     */
    public string $id;

    /**
     * @MongoDB\Field
     */
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
