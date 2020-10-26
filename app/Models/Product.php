<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models
 */
class Product extends Model
{
    /**
     * @var string
     */
    protected $table = 'products';
    /**
     * @var string[]
     */
    protected $casts = [
        'isArchived' => 'boolean',
        'isInventory' => 'boolean'
    ];
    /**
     * Here we specify request input attributes
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'productNo',
        'suppliersProductNo',
        'isArchived',
        'isInInventory',
        'imageId',
        'imageUrl',
    ];
    // This make all fields fillable in model
    protected $guarded = [];
}
