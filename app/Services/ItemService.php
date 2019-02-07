<?php

namespace App\Services;

use App\Models\Item;
use App\Services\Contracts\ItemServiceInterface;


class ItemService implements ItemServiceInterface
{
    /**
     * @param string $search
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function partNumberLookup(string $search = '', int $limit = 10)
    {
        /*
         * Be sure to only use a % on the right side. Doing so will allow the index to be used
         */
        return Item::select(['id', 'part_number'])
                   ->where('part_number', 'like', $search . '%')
                   ->orderBy('part_number')
                   ->limit($limit)
                   ->get();
    }
}