<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{ Builder, Model };
use App\Exceptions\NotEnoughTicketsException;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Concert extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * Include only concert published.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * Get the format date.
     *
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        return $this->date->format('F j, Y');
    }

    /**
     * Get the format time.
     *
     * @return string
     */
    public function getFormattedStartTimeAttribute()
    {
        return $this->date->format('g:ia');
    }

    /**
     * Get the ticket price in dollars.
     *
     * @return string
     */
    public function getTicketPriceInDollarsAttribute()
    {
        return number_format($this->ticket_price / 100, 2);
    }

    /**
     * Add ticket to a order.
     *
     * @param  string  $email
     * @param  int  $ticketQuantity
     * @return \App\Models\Order
     */
    public function orderTickets(string $email, int $ticketQuantity)
    {
        $tickets = $this->tickets()->available()->take($ticketQuantity)->get();
        
        if ($tickets->count() < $ticketQuantity) {
            throw new NotEnoughTicketsException();
        }

        $order = $this->orders()->create(['email' => $email]);
        
        foreach ($tickets as $ticket) {
            $order->tickets()->save($ticket);
        }

        return $order;
    }

    /**
     * Add tickets.
     *
     * @param  int  $quantity
     * @return void
     */
    public function addTickets(int $quantity)
    {
        foreach (range(1, $quantity) as $i) {
            $this->tickets()->create([]);
        }
    }

    /**
     * Get the total tickets remaining.
     *
     * @return int
     */
    public function ticketsRemaining()
    {
        return $this->tickets()->available()->count();
    }

    /**
     * Define a one-to-many relationships.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
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
