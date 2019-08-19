<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Release order_id.
     *
     * @param  array  $options
     * @return bool
     */
    public function release(array $options = [])
    {
        $this->forceFill(['order_id' => null]);

        return $this->save($options);
    }

    /**
     * Include only ticket's available.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeAvailable(Builder $query)
    {
        return $query->whereNull('order_id');
    }
}
