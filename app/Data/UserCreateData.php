<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Attributes\Validation\RequiredUnless;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class UserCreateData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $name,
        #[Required, StringType, Email, Unique('users', 'email')]
        public string $email,
        #[Required]
        public string $password,
        #[BooleanType]
        public bool   $is_admin,
        #[RequiredUnless('is_admin', true), IntegerType]
        public int    $department_id
    )
    {
    }
}

