<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * @package App\Models
 */
class Contact extends Model
{
    /**
     * type enum values
     */
    public static $TYPES = ['company', 'person'];
    /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     * Here we specify request input attributes
     * @var string[]
     */
    protected $fillable = [
        'type',
        'name',
        'organization_id',
        'createdTime',
        'contact_id',
        'countryId',
        'street',
        'accessCode'
    ];
    // This make all fields fillable in model
    protected $guarded = [];

}
