<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwapiCache extends Model
{
    use HasFactory;

    protected $primaryKey = 'key';
    protected $fillable = ['value'];

    public $table = 'swapi_cache';
    public $timestamps = false;
    public $incrementing = false;
}
