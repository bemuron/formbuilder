<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    public function index()
    {
        //$eventsList = $this->getOngoingEvents();
        //return view('home',compact('eventsList'));
        return view('home');
    }

    //get all events that have ongoing elections
    public function getOngoingEvents(){
        // return DB::table('events')
        //     ->distinct()
        //     ->select('events.id','events.name',
        //             DB::raw("IF(LENGTH(events.name) <= 22, events.name,
        //             CONCAT(LEFT(events.name, 22), '...')) AS name"),
        //             DB::raw("IF(LENGTH(events.description) <= 20, events.description,
        //                     CONCAT(LEFT(events.description, 20), '...')) AS description"), 
        //             'events.image')
        //     ->orderBy('events.id','asc')
        //     ->get();

            //TODO use code below when elections are made
        return DB::table('events')
            ->distinct()
            ->select('events.id','elections.end_date',
                    DB::raw("IF(LENGTH(events.name) <= 22, events.name,
                    CONCAT(LEFT(events.name, 22), '...')) AS name"),
                    DB::raw("IF(LENGTH(events.description) <= 10, events.description,
                            CONCAT(LEFT(events.description, 10), '...')) AS description"), 
                    'events.image')
            ->join('elections', 'elections.event_id', '=', 'events.id')
            ->where([
                ['elections.end_date', '>', NOW()],
                ['elections.status', '=', 1],
                ['elections.voting_type', '=', 2],
            ])
            ->orderBy('events.id','asc')
            ->get();
    }
}
