<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    /**
     * Sets the constant for created event
     **/
    const CREATED = 'created';

    /**
     * Sets the constant for updated event
     **/
    const UPDATED = 'updated';

    /**
     * Sets the constant for deleted event
     **/

    const DELETED = 'deleted';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description','subject_id','subject_type','user_id','properties','host'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['properties' => 'collection'];
}