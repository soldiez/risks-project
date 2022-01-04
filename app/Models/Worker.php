<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Worker extends Model
{
    use HasFactory;
    use AsSource, Attachable, Filterable;

    /**
     * @var array
     */

    protected $fillable = [

        'last_name',
        'first_name',
        'middle_name',
        'phone',
        'email',
        'personnel_number',
        'job_position',
        'department',
        'unit_id',
        'birthday',
        'status'
        ];
    protected $allowedSorts = [
        'last_name',
        'first_name',
        'job_position',
        'department',
        'unit_id',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $allowedFilters = [
        'last_name',
        'first_name',
        'middle_name',
        'job_position',
        'department',
        'unit_id',
        'status',
        'created_at',
        'updated_at'
    ];
    
}
