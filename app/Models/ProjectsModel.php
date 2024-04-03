<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsModel extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'projectName',
        'category',
        'client',
        'startDate',
        'description',
        'url',
        'completion',
        'completionDate',
        'picture'
    ];
}
