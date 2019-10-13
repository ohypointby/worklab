<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'update_at', 'deleted_at'
    ];

    /**
     * Belongs-to-many communication with products.
     *
     * @return belongsToMany
     */
    public function products() {
        return $this->belongsToMany('App\Product');
    }
}
