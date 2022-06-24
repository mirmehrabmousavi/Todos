<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function home()
    {
        $todos = Todo::latest()->paginate(8);
        return view('home', compact('todos'));
    }

    public function createTodo()
    {
        return view('addTodo');
    }

    public function storeTodo(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'tags' => 'required',
        ]);

        Todo::create([
            'title' => $request->title,
            'date' => $request->date,
            'status' => 'ثبت اولیه',
            'tags' => $request->tags
        ]);

        return redirect(route('home'))->with('success', 'created successfully');
    }

    public function editTodo($id)
    {
        $todo = Todo::findOrFail($id);
        return view('editTodo', compact('todo'));
    }

    public function updateTodo($id, Request $request)
    {
        $todo = Todo::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'date' => 'required',
        ]);

        $todo->update([
            'title' => $request->title,
            'date' => $request->date,
            'status' => 'ثبت اولیه',
            'tags' => $request->tags
        ]);

        return redirect(route('home'))->with('success', 'updated successfully');
    }

    public function deleteTodo($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()->back()->with('success', 'deleted successfully');
    }

    public function adminHome()
    {
        $todos = Todo::latest()->paginate(8);
        return view('admin-home', compact('todos'));
    }

    public function confirm($id)
    {
        $todo = Todo::findOrFail($id);

        $now_date = new DateTime();
        $due_date = new DateTime($todo->date);
        if ($now_date > $due_date) {
            $todo->update([
                'status' => 'به پایان رسیده'
            ]);

        }else {
            $todo->update([
                'status' => 'تایید شده'
            ]);

        }

        return redirect(route('admin.home'))->with('success', 'done successfully');
    }

    public function decline($id)
    {
        $todo = Todo::findOrFail($id);
        $now_date = new DateTime();
        $due_date = new DateTime($todo->date);
        if ($now_date > $due_date) {
            $todo->update([
                'status' => 'به پایان رسیده'
            ]);
        } else {
            $todo->update([
                'status' => 'رد شده'
            ]);
        }

        return redirect(route('admin.home'))->with('success', 'done successfully');
    }

    public function confirmAll()
    {
        DB::table('todos')/*->where('id',$request->input('symbols'))*/->update(['status' => 'تایید شده']);

        return redirect(route('admin.home'))->with('success','done');
    }

    public function declineAll()
    {
        DB::table('todos')->update(['status' => 'رد شده']);

        return redirect(route('admin.home'))->with('success','done');
    }

    public function filterDate(Request $request)
    {
        $start = Carbon::parse($request->first);
        $end = Carbon::parse($request->end);

        $todos = Todo::where('date','<=',$end)
            ->where('date','>=',$start)->get();

        return view('filterDate',compact('todos'));
    }
}
