<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class GameSessionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $gameSessions = GameSession::with('getUserNames:id,name')->get();


        return view('gamesessions.gameSessionIndex')->with('gamesessions', $gameSessions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (isset (Auth::user()->id)) {
            return view('gamesessions.gameSessionsNew');
        } else {
            return view('utils.authentificationRequired');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $gameSession = new GameSession();

        $gameSession->user_id = $request->user()->id;
        $gameSession->title = $request->title;
        $gameSession->game = $request->game;
        $gameSession->description = $request->description;
        $gameSession->slug = str_slug($gameSession->title);

        $gameSession->save();

        return redirect()->route('gamesession.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

    }

}

?>