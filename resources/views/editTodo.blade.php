@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">add</div>
            </div>
            <div class="card-body">
                <form action="{{route('updateTodos',['id' => $todo->id])}}" method="POST">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="exampleInputEmail1">title</label>
                        <input type="text" name="title" class="form-control" value="{{$todo->title}}" placeholder="title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">date</label>
                        <input type="date" name="date" class="form-control" placeholder="date" value="{{$todo->date}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">tags</label>
                        <select name="tags" class="form-control" id="tags">
                            <option value="1">آبی</option>
                            <option value="2">قرمز</option>
                            <option value="3">نارنجی</option>
                            <option value="4">سفید</option>
                            <option value="5">سیاه</option>
                            <option value="6">بنفش</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
