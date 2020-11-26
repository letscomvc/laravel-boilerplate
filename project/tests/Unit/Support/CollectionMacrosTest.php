<?php

namespace Tests\Unit\Support;

use App\Support\CollectionMacros;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\Cases\TestCaseUnit;

class CollectionMacrosTest extends TestCaseUnit
{
    public function testPaginate()
    {
        $collectionToPaginate = Collection::make(['a', 'b', 'c']);
        $pagination = $collectionToPaginate->paginate(1);
        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);
        $this->assertSame($pagination->perPage(), 1);
        $this->assertSame($pagination->total(), 3);
        $this->assertSame($pagination->currentPage(), 1);

        $paginationNextPage = $collectionToPaginate->paginate(1, 2);
        $this->assertSame($paginationNextPage->total(), 3);
        $this->assertSame($paginationNextPage->perPage(), 1);
        $this->assertSame($paginationNextPage->currentPage(), 2);
    }

    public function testAllEquals()
    {
        $emptyCollection = Collection::make();
        $this->assertTrue($emptyCollection->allEquals());

        $dataWithSingleElement = Collection::make([1])
            ->collect();
        $dataWithSimpleRepeated = Collection::make([1, 1])
            ->collect();
        $dataWithSimpleNotRepeated = Collection::make([1, 2])
            ->collect();
        $this->assertTrue($dataWithSingleElement->allEquals());
        $this->assertTrue($dataWithSimpleRepeated->allEquals());
        $this->assertFalse($dataWithSimpleNotRepeated->allEquals());

        $dataWithCustomElementRepeated = Collection::make([
            ['simpleKey' => 'simpleValue'],
            ['simpleKey' => 'simpleValue'],
        ])
            ->collect();
        $this->assertTrue(
            $dataWithCustomElementRepeated->allEquals(function ($element) {
                return $element['simpleKey'];
            })
        );

        $dataWithCustomElementNotRepeated = Collection::make([
            ['simpleKey' => 'simpleValue'],
            ['simpleKey' => 'anotherSimpleValue'],
        ])
            ->collect();
        $this->assertFalse(
            $dataWithCustomElementNotRepeated->allEquals(function ($element) {
                return $element['simpleKey'];
            })
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        CollectionMacros::register();
    }
}
