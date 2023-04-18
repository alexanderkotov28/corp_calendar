<?php

namespace App\Data;

use App\Data\Casts\DateCast;
use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\DateFormat;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class EventData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string  $title,
        #[WithCast(DateCast::class), DateFormat('d-m-Y H:i')]
        public Carbon  $start_date,
        #[WithCast(DateCast::class), DateFormat('d-m-Y H:i')]
        public Carbon  $end_date,
        #[ArrayType]
        public array   $departments,
        #[ArrayType]
        public array   $users,
        #[StringType]
        public ?string $description = null,
    )
    {
    }

    #[ArrayShape(['title' => "string", 'start_date' => "\Carbon\Carbon", 'end_date' => "\Carbon\Carbon", 'description' => "null|string", 'created_by' => "int"])]
    public function getEventAttributes(): array
    {
        return [
            'title' => $this->title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
            'created_by' => auth()->user()->id
        ];
    }
}
