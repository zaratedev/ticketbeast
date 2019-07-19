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
        $request->validate([
            'email' => 'required',
        ]);

        $concert = Concert::find($id);

        $this->paymentGateway->charge($request->ticket_quantity * $concert->ticket_price, $request->payment_token);

        $order = $concert->orderTickets($request->email, $request->ticket_quantity);
        
        return response()->json([], 201);
    }
}
