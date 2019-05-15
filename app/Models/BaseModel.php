<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BaseModel extends Model
{
    /**
     * Shows All the columns of the Corresponding Table of Model
     *
     * If You need to get all the Columns of the Model Table.
     * Useful while including the columns in search
     *
     * @return array
     **/
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * Accessor for formatting the created_at field
     *
     * Formats the created_at attribute with carbon
     *
     * @author Manojkiran.A <manojkiran1003199@gmail.com>
     * @return string
     **/
    public function getCreatedAtAttribute()
    {
        return Carbon::createFromDate($this->attributes['created_at'])->toFormattedDateString();
    }

    /**
     * Scope a query to Disable EagerLoading
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutRelations($query)
    {
        return $query->setEagerLoads([]);
    }
}
