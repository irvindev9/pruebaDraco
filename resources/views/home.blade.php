@extends('layouts.app')

@section('content')
    <master-component :todaydate="{{$day}}" />
@endsection
