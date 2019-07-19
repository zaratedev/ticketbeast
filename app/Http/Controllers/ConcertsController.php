<?php

namespace App\Http\Controllers;

use App\Models\Concert;

class ConcertsController extends Controller
{
    /**
     * Display the single of concert.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $concert = Concert::published()->findOrFail($id);

        return view('concerts.show', compact('concert'));
    }
}
