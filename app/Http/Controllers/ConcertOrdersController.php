<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Billing\PaymentGateway;
use App\Models\Concert;

class ConcertOrdersController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }
    
    public function store(Request $request, $id)
    {
        $concert = Concert::find($id);
        $ticketQuantity = $request->get('ticket_quantity');
        $amount = $ticketQuantity * $concert->ticket_price;
        $key = $request->get('payment_token');
        $this->paymentGateway->charge($amount, $key);

        $order = $concert->orders()->create(['email' => $request->get('email')]);

        foreach (range(1, $ticketQuantity) as $i) {
            $order->tickets()->create([]);
        }
        
        return response()->json([], 201);
    }
}
