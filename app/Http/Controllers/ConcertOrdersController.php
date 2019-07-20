<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;
use App\Billing\PaymentGateway;
use App\Billing\PaymentFailedException;

class ConcertOrdersController extends Controller
{
    /**
     * @var \App\Billing\PaymentGateway;
     */
    protected $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }
    
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'email' => 'required',
            'payment_token' => 'required',
            'ticket_quantity' => 'required',
        ]);

        try {
            $concert = Concert::find($id);
    
            $this->paymentGateway->charge($request->ticket_quantity * $concert->ticket_price, $request->payment_token);
    
            $order = $concert->orderTickets($request->email, $request->ticket_quantity);
            
            return response()->json([], 201);
        } catch (PaymentFailedException $e) {
            return response()->json([], 422);
        }
    }
}
