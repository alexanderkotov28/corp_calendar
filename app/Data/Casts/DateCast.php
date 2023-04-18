<?php

namespace App\Data\Casts;

use Carbon\Carbon;
use Spatie\LaravelData\Support\DataProperty;

class DateCast implements \Spatie\LaravelData\Casts\Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return Carbon::createFromFormat('d-m-Y H:i', $value);
    }
}
