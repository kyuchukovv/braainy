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
        'isInInventory' => 'boolean'
    ];
    /**
     * Here we specify request input attributes
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'name',
        'description',
        'productNo',
        'organization_id',
        'account_id',
        'salesTaxRulesetId',
        'suppliersProductNo',
        'isArchived',
        'isInInventory',
        'imageId'
    ];
    // This make all fields fillable in model
    protected $guarded = [];

    public function getFillableAttributes(){
        $fillable = $this->getFillable();
        $attributes = $this->getAttributes();

        foreach ($attributes as $key => $attribute){
            if (!array_search($key, $fillable)) {
                unset($attributes[$key]);
            }
        }

        return $attributes;
    }

}
