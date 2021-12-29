<?php

namespace App\Events;

use App\Models\VinSuggestion;
use Illuminate\Queue\SerializesModels;

class VinSuggestionCreated
{
    use SerializesModels;

    public function __construct(public VinSuggestion $vinSuggestion)
    {
    }
}
