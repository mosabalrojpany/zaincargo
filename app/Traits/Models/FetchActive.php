<?php

namespace App\Traits\Models;

/**
 *  Fetch Active rows from database Trait
 */
trait FetchActive
{

    /**
     * Scope a query to only include active rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Scope a query to only include active rows or id quals specific value.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveOrId($query, $id)
    {
        return $query->active()->orWhere('id', $id);
    }

}
