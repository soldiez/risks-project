<?php

namespace App\Models\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class UnitTerritory extends Model
{
    use HasFactory;
   // use NodeTrait;
    use asSource, Filterable;

    protected $attributes = [
        'status' => 'active',
    ];

    protected $fillable = [
        'unit_id',
        'parent_id',
        'name',
        'responsible_id',
        'unit_department_id',
        'coordinate',
        'address',
        'info',
        'status'
    ];

    protected $allowedSorts = [
            'unit_id',
            'parent_id',
            'name',
            'responsible_id',
            'unit_department_id',
            'coordinate',
            'address',
            'status'
    ];

    protected $allowedFilters = [
        'unit_id',
        'parent_id',
        'name',
        'responsible_id',
        'unit_department_id',
        'coordinate',
        'address',
        'status'
    ];

//    public function parent(){
//        return $this->belongsTo('UnitTerritory', 'parent_id');
//    }
//    Public function children(){
//        return $this->hasMany(UnitTerritory::class, 'parent_id', 'id');
//    }
//    public function childrenRecursive(){
//        return $this->children()->with('childrenRecursive');
//    }
//    public function categories(){
//        return $this->hasMany(UnitTerritory::class, 'parent_id', 'id');
//    }
//    public function childrenCategories(){
//        return $this->hasMany(UnitTerritory::class, 'parent_id', 'id')->with('categories');
//    }

}
