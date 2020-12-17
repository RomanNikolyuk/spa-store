<?php


namespace App\Components\CollectionPaginator;
use Illuminate\Pagination\Paginator as DefaultPaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CollectionPaginator
{
    public static function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (DefaultPaginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
