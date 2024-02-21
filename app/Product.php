<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'type',
        'name',
        'import_price',
        'price',
        'url_detail',
        'path_thumb',
        'status',
    ];

    /**
     * Relationship with mover
     *
     * @return mixed
     */
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
}
