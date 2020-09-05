@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 my-1">
            <a class="btn btn-light px-2">
                <img src="https://img.icons8.com/fluent-systems-filled/15/000000/plus-math.png"/> Agregar tarea
            </a>
        </div>
        <div class="col-md-5 my-1 text-right">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light">
                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/back.png"/> Anterior
                </button>
                <button type="button" class="btn btn-light">
                    Siguiente <img src="https://img.icons8.com/fluent-systems-filled/15/000000/more-than.png"/>
                </button>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $days[date("l")] }} <small>{{ date("j") }} {{ $months[date("F")] }}</small></h5>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
