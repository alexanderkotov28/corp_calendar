<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class UserSearchData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $search
    )
    {
    }
}
