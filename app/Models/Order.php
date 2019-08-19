<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function cancel()
    {
        foreach ($this->tickets as $ticket) {
            $ticket->update(['order_id' => null]);
        }

        $this->delete();
    }

    /**
     * Define a one-to-many relationships.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets() : HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
