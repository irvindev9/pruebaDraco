@extends('layouts.app')

@section('content')
    {{-- <script>
        let date1 = '{{$days[date("l")]}}';
        let date2 = '{{date("j") .' '.$months[date("F")]}}';
    </script> --}}
    <example-component :todaydate="0" />
@endsection
