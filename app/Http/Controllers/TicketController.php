<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return the view
        $tickets = Ticket::all();
        return view('admin.tickets.index', compact("tickets"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.tickets.create');
    }
    public function book(Request $request,Room $room)
    {
        if (Auth::check()) {
        $rooms = DB::table('room_user')->where('room_id', $room->id)->get();
        $error=false;
        foreach($rooms as $single){
            $in=$single->check_in;
            $out=$single->check_out;
             if(($request->check_in >= $in && $request->check_in <= $out )  ($request->check_out >= $in && $request->check_out <= $out)  ($request->check_in <= $in && $request->check_out >= $out ) ){
                 $error=true;
                 return redirect()->back()->with('message','this date is already booked');
                 break;

        }}
        if(!$error){
             $id=Auth::user()->id;
            // $room= new Room();
            $room->users()->attach($id,['check_in'=> $request->check_in,'check_out'=>$request->check_out,'phone'=>$request->phone]);
            return redirect()->back()->with('success','This Room Booked Successfully');
        }

        }

        else{
            return redirect('/login');
        }}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Ticket::create($request->all());
        $tickets = Ticket::all();
        return view('admin.tickets.index', compact("tickets"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
        $tickets = Ticket::find($ticket->id);
        // dd($oneProduct);
        return view('moviegrid', compact('tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    // return to the  edit view
    public function edit(Ticket $ticket)
    {
        //
        return view('admin.tickets.edit', compact("ticket"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */

    ///update on database
    public function update(Request $request, Ticket $ticket)
    {
        //
        $ticket->update($request->all());
        $tickets = Ticket::all();
        return view('admin.tickets.index', compact("tickets"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
        $ticket->delete();
        return redirect()->back();
    }



}
