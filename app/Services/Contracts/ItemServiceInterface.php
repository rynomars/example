<?php

namespace App\Services\Contracts;

Interface ItemServiceInterface
{

    /**
     * @param string $search
     * @param int $limit
     * @return mixed
     */
    public function partNumberLookup(string $search, int $limit=25);
}
