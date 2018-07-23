<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $tables = 'items';
    protected $fillable = ['name','category','price'];
}
