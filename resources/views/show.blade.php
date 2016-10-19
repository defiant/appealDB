@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column">
                <div class="content">
                    <h1 class="title">{{$appeal->event->event_name}}</h1>
                    <p class="subtitle">{{$appeal->event->session}}</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="columns">
            <div class="column is-5">
                <div class="hand-diagram">
                    @if($appeal->board->screen)
                        <svg width="100%" height="100%" viewport="0 0 120 120" xmlns="http://www.w3.org/2000/svg" style="position: absolute;">
                            <line x1="0" y1="0" x2="320" y2="240" stroke-width="4" stroke="black"></line>
                        </svg>
                    @endif
                    <div class="hand-row">
                        <div class="north hand">
                            <ul>
                                @foreach($hands['n'] as $line)
                                    <li>{{$line}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="hand-row is-clearfix">
                        <div class="west hand">
                            <ul>
                                @foreach($hands['w'] as $line)
                                    <li>{{$line}}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="east hand">
                            <ul>
                                @foreach($hands['e'] as $line)
                                    <li>{{$line}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="hand-row">
                        <div class="south hand">
                            <ul>
                                @foreach($hands['s'] as $line)
                                    <li>{{$line}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="hand-info">
                    <ul>
                        <li>Board No: {{$appeal->board->board_no}}</li>
                        <li>Dealer: {{config('bridge.dealer')[$appeal->board->dealer]}}</li>
                        <li>Vulnerable: {{$appeal->board->vul}}</li>
                    </ul>
                </div>

                <hr>
                <div class="auction">
                    <h2 class="title is-4">Auction</h2>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>North</th>
                            <th>East</th>
                            <th>South</th>
                            <th>West</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($auction as $k => $bid)
                                @if($k % 4 === 0)
                                    <tr>
                                @endif
                                    <td>{{strtoupper($bid)}}</td>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="alerts content">
                    @if($alerts)
                        <ol>
                            @foreach($alerts as $alert)
                                <li>{{$alert}}</li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>

            <div class="column is-7">
                <div class="content">
                    <p class="subtitle">{{$appeal->appeal_time->toFormattedDateString()}}</p>

                    <p>
                        <strong>Level</strong>: {{$appeal->event->level}} <br>
                        <strong>NBO</strong>: {{$appeal->event->nbo}}
                    </p>
                    <p>
                        <strong>Director</strong>: {{$appeal->director}} <br>
                        <strong>Committee</strong>: {{$appeal->committee}}
                    </p>
                    <p>
                        <strong>Players</strong>: <br>
                        N/S: {{$appeal->player_north}} - {{$appeal->player_south}} <br>
                        E/W: {{$appeal->player_east}} - {{$appeal->player_west}} <br>
                    </p>
                    <p><strong>Related Laws</strong>: {{$appeal->laws}}</p>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <hr>
                <div class="content">
                    <h2>Facts</h2>
                    @markdown($appeal->facts)

                    <h2>Ruling</h2>
                    @markdown($appeal->ruling)

                    <h2>Appeal reason</h2>
                    @markdown($appeal->appeal_reason)

                    <h2>Decision</h2>
                    @markdown($appeal->decision)
                </div>
            </div>
        </div>
    </div>
{{--{{dd($appeal)}}--}}
@endsection