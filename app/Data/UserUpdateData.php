<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredUnless;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class UserUpdateData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string  $name,
        #[Required, StringType, Email, Unique('users', 'email', ignore: new RouteParameterReference('user', 'email'), ignoreColumn: 'email')]
        public string  $email,
        public ?string $password,
        #[BooleanType]
        public bool    $is_admin,
        #[RequiredUnless('is_admin', true)]
        public int     $department_id
    )
    {
    }
}
