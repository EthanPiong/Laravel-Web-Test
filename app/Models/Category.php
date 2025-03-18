<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description' , 'image_url'];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
