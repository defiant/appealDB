@extends('layouts.app')

@section('content')
    <table class="table">
        @foreach($appeals as $appeal)
            <tr>
                <td>{{$appeal->event->event_name}} - {{$appeal->event->event_name}}</td>
                <td>{{$appeal->created_at}}</td>
            </tr>
        @endforeach
    </table>
@endsection
