<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundsModel extends Model
{
    use HasFactory;

    protected $table = 'backgrounds';

    protected $fillable = [
        'name',
        'place',
        'year',
        'address',
        'bgType',
        'description'
    ];
}
