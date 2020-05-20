<?php


namespace App\ProductCatalog\Services\Formatter\Http;


use Illuminate\Pagination\LengthAwarePaginator;

class AllPaginatedProductsFormatter
{
    public function format(LengthAwarePaginator $paginatedProducts)
    {
        $d = '';
        return [
            'currentPage' => $paginatedProducts->currentPage(),
            'hasMorePages' => $paginatedProducts->hasMorePages(),
            'numberOfItemsOnCurrentPage' => $paginatedProducts->count(),
            'numberOfItemsTotal' => $paginatedProducts->total(),
            'itemsPerPage' => $paginatedProducts->perPage(),
            'currentPageItems' => $paginatedProducts->items()
        ];
    }
}
