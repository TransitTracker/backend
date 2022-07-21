<?php

namespace App\Events\Vin;

use App\Models\Vin\Suggestion;
use Illuminate\Queue\SerializesModels;

class SuggestionCreated
{
    use SerializesModels;

    public function __construct(public Suggestion $suggestion)
    {
    }
}
