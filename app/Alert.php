<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['title_en', 'title_fr', 'body_en', 'body_fr', 'colour', 'expiration'];
}
