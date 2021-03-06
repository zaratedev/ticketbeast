<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;
use App\Exceptions\NotEnoughTicketsException;
use App\Billing\{ PaymentGateway, PaymentFailedException };

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
     * @throws \App\Billing\PaymentFailedException|\App\Exceptions\NotEnoughTicketsException
     */
    public function store(Request $request, $id)
    {
        $concert = Concert::published()->findOrFail($id);

        $request->validate([
            'email' => 'required',
            'payment_token' => 'required',
            'ticket_quantity' => 'required',
        ]);

        try {
            /** @var \App\Models\Order $order */
            $order = $concert->orderTickets($request->email, $request->ticket_quantity);
            $this->paymentGateway->charge($request->ticket_quantity * $concert->ticket_price, $request->payment_token);

            return response()->json([
                'email' => $request->email,
                'ticket_quantity' => $request->ticket_quantity,
                'amount' => $this->paymentGateway->totalCharges(),
            ], 201);
        } catch (PaymentFailedException $e) {
            $order->cancel();

            return response()->json([], 422);
        } catch (NotEnoughTicketsException $e) {
            return response()->json([], 422);
        }
    }
}
