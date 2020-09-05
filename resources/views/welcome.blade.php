@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3 my-3">
            <img src="{{asset('img/timer.svg')}}" class="img-fluid" alt="timer-person">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="list-group">
                <a class="list-group-item list-group-item-action" href="{{ route('register') }}">
                    Nuevo usuario <img src="https://img.icons8.com/small/16/000000/arrow.png"/>
                </a>
                <a class="list-group-item list-group-item-action" href="{{ route('login') }}">
                    Ingresar <img src="https://img.icons8.com/small/16/000000/arrow.png"/>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
