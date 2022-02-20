<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// ログインしているユーザーの投稿のみをレスポンスとして返すため

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goals = Auth::user()->goals;

        return response()->json($goals);
        // Laravelではresponseというヘルパーを使うことでアクションからレスポンスを返すことができる
        // 今回はユーザーが作成した全てのGoalをJSON形式でレスポンスとして返しています。
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $goal = new Goal();
        $goal->title = request('title');
        $goal->user_id = Auth::id();
        $goal->save();

        $goals = Auth::user()->goals;

        return response()->json($goals);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Goal  $goal
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Goal $goal)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Goal  $goal
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Goal $goal)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal)
    {
        $goal->title = request('title');
        $goal->user_id = Auth::id();
        $goal->save();

        $goals = Auth::user()->goals;

        return response()->json($goals);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal)
    {
        $goal->delete();

        $goals = Auth::user()->goals;

        return response()->json($goals);
    }
}
