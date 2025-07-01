<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Republish extends Pivot
{
    protected $table = 'republishes';
    protected $guarded = ['id'];
}
