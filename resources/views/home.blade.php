@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title is-1">AppealDB</h1>
        <p class="subtitle">
            A database for Bridge Appeals
        </p>

        <table class="table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Date</th>
                </tr>
            </thead>
            @foreach($appeals as $appeal)
                <tr>
                    <td>
                        <a href="/{{$appeal->id}}">
                            {{$appeal->event->event_name}} - {{$appeal->event->session}}
                        </a>
                    </td>
                    <td>{{$appeal->appeal_time->toFormattedDateString()}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
