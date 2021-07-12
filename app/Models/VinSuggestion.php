<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VinSuggestion extends Model
{
    use HasFactory;

    protected $fillable = ['vin', 'label', 'note'];
}
