@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Todos
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><input type="checkbox" name="selectAll" class="selectAll" id="selectAll"></th>
                        <th scope="col">title</th>
                        <th scope="col">date</th>
                        <th scope="col">status</th>
                        <th scope="col">tags</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($todos as $value)
                        <tr>
                            <th scope="row">{{$loop->index+1}}</th>
                            <td><input type="checkbox" name="symbols[]" class="checkboxAll" value="{{$value->id}}"></td>
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
                                <a class="btn btn-success" href="{{ route('confirmTodo',['id' => $value->id]) }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('confirm').submit();">confirm</a>
                                <form id="confirm" action="{{ route('confirmTodo',['id' => $value->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('patch')
                                </form>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="{{ route('declineTodo',['id' => $value->id]) }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('decline').submit();">decline</a>
                                <form id="decline" action="{{ route('declineTodo',['id' => $value->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('patch')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="{{route('confirmAll')}}" class="btn btn-primary" onclick="event.preventDefault();
                                                     document.getElementById('confirmAll').submit();">confirm all</a>

                        <form id="confirmAll" action="{{ route('confirmAll') }}"
                              method="POST">
                            @csrf
                            @method('patch')
                        </form>
                        </td>
                        <td>
                            <a href="{{route('declineAll')}}" class="btn btn-danger" onclick="event.preventDefault();
                                                     document.getElementById('declineAll').submit();">decline all</a>

                            <form id="declineAll" action="{{ route('declineAll') }}"
                                  method="POST">
                                @csrf
                                @method('patch')
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
                {{$todos->links('pagination.paginate')}}
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{route('filterDate')}}" method="GET">
                            @csrf
                            <input type="date" name="first" class="form-control">
                            <input type="date" name="end" class="form-control">
                            <button type="submit" class="btn btn-primary">filter</button>
                        </form>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
