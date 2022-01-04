<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\Screen\Contracts\Fieldable;

class Category extends Model
{
    use HasFactory, SoftDeletes
     //   NestableTrait
        ;
    use AsSource, Attachable, Filterable;

    protected $fillable = [
        'id',
      'parent_id',
      'name',
        'info',
    ];

    protected $allowedSorts = [
        'parent_id',
        'name'
    ];

    protected $allowedFilters = [
        'parent_id',
        'name'
    ];
   // protected $parent = 'parent_id';

//    public function categories()
//    {
//        return $this->hasMany(Category::class);
//    }
//    public function childrenCategories()
//    {
//        return $this->hasMany(Category::class)->with('categories');
//    }
//    public function childs()
//    {
//        return $this->hasMany(Category::class, 'parent_id', 'id');
//    }
}
