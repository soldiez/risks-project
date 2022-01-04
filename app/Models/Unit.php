<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Unit extends Model
{
    use HasFactory;
    use AsSource, Attachable, Filterable;

    protected $fillable = [
        'short_name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'unit_manager',
        'unit_manager_phone',
        'unit_manager_email',
        'unit_safety_manager',
        'unit_safety_manager_phone',
        'unit_safety_manager_email',
        'legal_address',
        'post_address',
        'parent_unit_id',
        'status',
        'logo_unit'
    ];
    protected $allowedSorts = [
        'short_name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'unit_manager',
        'unit_manager_phone',
        'unit_manager_email',
        'unit_safety_manager',
        'unit_safety_manager_phone',
        'unit_safety_manager_email',
        'legal_address',
        'post_address',
        'parent_unit_id',
        'status'
    ];

    protected $allowedFilters = [
        'short_name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'unit_manager',
        'unit_manager_phone',
        'unit_manager_email',
        'unit_safety_manager',
        'unit_safety_manager_phone',
        'unit_safety_manager_email',
        'legal_address',
        'post_address',
        'parent_unit_id',
        'status'
    ];

}
