<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Goal;
// 設定したリレーションを使用するためapp/Goal.phpも追加している
use App\Tag;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// ログインしているユーザーのTodoのみをレスポンスとして返したいので、以下を追加しました。

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Goal $goal)
    {
        $todos = $goal->todos()->with('tags')->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todos);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Goal $goal)
    {
        $todo = new Todo();
        $todo->content = request('content');
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->position = request('position');
        $todo->done = false;
        $todo->save();
        $todos = $goal->todos()->with('tags')->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todo);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal, Todo $todo)
    {
        $todo->content = request('content');
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->position = request('position');
        $todo->done = (bool) request('done');
        $todo->save();

        $todos = $goal->todos()->with('tags')->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todos);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Goal $goal, Todo $todo)
    {
        $todo->delete();
        $todos = $goal->todos()->with('tags')->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todos);
    }

    public function sort(Request $request, Goal $goal, Todo $todo)
    {
        $exchangeTodo = Todo::where('position', request('sortId'))->first();
        $lastTodo = Todo::where('position', request('sortId'))->latest('position')->first();

        if (request('sortId') == 0) {
            $todo->moveBefore($exchangeTodo);
        } else if (request('sortId') - 1 == $lastTodo->position) {
            $todo->moveAfter($exchangeTodo);
        } else {
            $todo->moveAfter($exchangeTodo);
        }

        $todos = $goal->todos()->with('tags')->orderBy('done', 'asc')->orderBy('position', 'asc')->get();
        return response()->json($todos);
    }
    public function addTag(Request $request, Goal $goal, Todo $todo, Tag $tag)
    {
        $todo->tags()->attach($tag->id);

        $todos = $goal->todos()->with('tags')->orderBy('done', 'asc')->orderBy('position', 'asc')->get();

        return response()->json($todos);
    }

    public function removeTag(Request $request, Goal $goal, Todo $todo, Tag $tag)
    {
        $todo->tags()->detach($tag->id);

        $todos = $goal->todos()->with('tags')->orderBy('done', 'asc')->orderBy('position', 'asc')->get();

        return response()->json($todos);
    }
}
