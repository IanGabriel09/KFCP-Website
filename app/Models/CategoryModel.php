<?php

namespace App\Models;

use App\Models\ProductModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'uuid', 'classification'];

    // Code below for declaring table relationship to product
    public function products()
    {
        return $this->hasMany(ProductModel::class, 'category_uuid', 'uuid');
    }

    // Code below for referencing uuid data in routes instead of the primary key which is "id"
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
