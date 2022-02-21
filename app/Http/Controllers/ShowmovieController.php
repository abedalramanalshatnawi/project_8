<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class ShowmovieController extends Controller
{
    //
    public function showmovie()
    {
        //return the view
        $tickets = Ticket::all();
        return view('moviegrid', compact("tickets"));
    }


    //
    public function showsinglemovie($id)
    {

        $ticket = Ticket::find($id);

        return view('moviesingle', compact("ticket"));
    }

    public function showbooking($id)
    {
        $ticket = Ticket::find($id);
        return view('ticketform',compact('ticket'));
    }
}