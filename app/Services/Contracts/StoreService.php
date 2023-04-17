<?php

namespace App\Services\Contracts;

use Spatie\LaravelData\Contracts\DataObject;

interface StoreService
{
    public function store(DataObject $data);

    public function update();
}
