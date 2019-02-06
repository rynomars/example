<?php

namespace App\Observers;

use App;
use App\Models\Item;
use App\Exceptions\ItemSaveException;


class ItemObserver
{
    /**
     * Listen to the Item saving event
     *
     * @param  Item $item
     * @throws ItemSaveException
     */
    public function saving(Item $item)
    {
        /*
         * Validate Required fields for saving
         */
        if (!isset($item->part_number) || is_null($item->part_number)) {
            throw new ItemSaveException('A part number is required to save item');
        }
        if (!isset($item->brand_id) || is_null($item->brand_id)) {
            throw new ItemSaveException('A brand id is required to save item');
        }
        if (!isset($item->status) || is_null($item->status)) {
            throw new ItemSaveException('A status is required to save item');
        }
    }

    /**
     * Listen to the Item updating event
     *
     * @param  Item $item
     * @throws ItemSaveException
     */
    public function updating(Item $item)
    {
        if (!in_array($item->status, Item::getUpdatableStatusKeys())) {
            throw new ItemSaveException('Item cannot be updated with provided status.');
        }

    }

    /**
     * Listen to the Item creating event
     *
     * @param  Item $item
     * @return void
     * @throws  ItemSaveException
     */
    public function creating(Item $item)
    {
        if (!in_array($item->status, Item::getCreatableStatusKeys()) ) {
            throw new ItemSaveException('Item cannot be created with provided status.');
        }
    }
}