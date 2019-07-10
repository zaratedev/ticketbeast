<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;

class ConcertsController extends Controller
{
    public function show($id)
    {
        $concert = Concert::whereNotNull('published_at')->findOrFail($id);

        return view('concerts.show', compact('concert'));
    }
}
