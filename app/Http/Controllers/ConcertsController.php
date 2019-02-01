<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;

class ConcertsController extends Controller
{
    public function show(Concert $concert)
    {
        return view('concerts.show', compact('concert'));
    }
}
