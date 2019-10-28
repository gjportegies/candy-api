<?php

namespace GetCandy\Api\Core\Reports\Providers;

use DB;
use Carbon\Carbon;
use GetCandy\Api\Core\Products\Models\Product;

class Products extends AbstractProvider
{
    public function attribute($attribute, $value, $expression = 'EQUALS')
    {
        return DB::table('products')
        ->select(
            'products.id',
            'sku',
            DB::RAW($this->getJsonColumn($attribute) . 'as value'),
            DB::RAW($this->getJsonColumn('name') . 'as name')
        )->where(
            DB::RAW($this->getJsonColumn($attribute)),
            $this->getExpression($expression),
            $value
        )->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->groupBy('products.id')
            ->paginate(25);
    }

    public function get()
    {
    }
}