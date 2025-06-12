<?php

namespace App\Models;

use App\Models\CategoryModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price', 'image', 'uuid', 'category_uuid'];

    // Code below for declaring table relationship to categories
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_uuid', 'uuid');
    }

    // Code below for referencing uuid data in routes instead of the primary key which is "id"
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
