<?php

namespace App\Events;

use App\Models\Tag;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TagUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Tag $tag)
    {
    }
}
