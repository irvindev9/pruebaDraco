@extends('layouts.app')

@section('content')

    <master-component :todaydate="{{$day}}" :user="{{$user}}"/>
@endsection
