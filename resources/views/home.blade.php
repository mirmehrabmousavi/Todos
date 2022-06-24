@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Todos
                    <a href="{{route('addTodos')}}" class="btn btn-outline-primary float-end">add</a>
                </div>

            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">title</th>
                        <th scope="col">date</th>
                        <th scope="col">status</th>
                        <th scope="col">tags</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($todos as $value)
                        <tr>
                            <th scope="row">{{$loop->index+1}}</th>
                            <td>{{$value->title}}</td>
                            <td>{{$value->date}}</td>
                            @php
                                $now_date = new DateTime();
                                $due_date = new DateTime($value->date);
                                $status = '';
                                $color = '';
                                if ($now_date > $due_date) {
                                    $status = 'به پایان رسیده';
                                    $color = 'danger';
                                }elseif($value->status === 'ثبت اولیه') {
                                    $color = 'primary';
                                    $status = $value->status;
                                }elseif($value->status === 'رد شده') {
                                    $color = 'warning';
                                    $status = $value->status;
                                }else{
                                    $status = $value->status;
                                    $color = 'success';
                                }
                            @endphp
                            <td><span class="badge badge-{{$color}} bg-{{$color}}">{{$status}}</span></td>
                            <td>{{$value->tags}}</td>
                            <td>
                                <a href="{{route('editTodos',['id' => $value->id])}}" class="btn btn-info">edit</a>
                                <a class="btn btn-danger" href="{{ route('deleteTodos',['id' => $value->id]) }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('del').submit();">delete</a>
                                <form id="del" action="{{ route('deleteTodos',['id' => $value->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$todos->links('pagination.paginate')}}
            </div>
        </div>
    </div>
@endsection
