@extends('layouts.app')

@section('title'){{$appeal->event->event_name}} appeal records - AppealDB.com @endsection

@section('meta_description')Appeal records for the event {{$appeal->event->event_name}} ({{$appeal->event->session}}) concerning {{config('bridge.categories')[$appeal->category_id]}} at board {{$appeal->board->board_no}}. The appeal was at {{$appeal->appeal_time->toFormattedDateString()}}. @if($appeal->laws) Related laws: {{$appeal->laws}} @endif @endsection

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
                <div class="hand-info columns">
                    <div class="column"><strong>Board No</strong>: {{$appeal->board->board_no}}</div>
                    <div class="column"><strong>Dealer</strong>: {{config('bridge.dealer')[$appeal->board->dealer]}}</div>
                    <div class="column"><strong>Vulnerable</strong>: {{strtoupper($appeal->board->vul)}}</div>
                </div>

                <div class="hand-diagram">
                    @if($appeal->board->screen)
                        <svg width="100%" height="100%" viewport="0 0 120 120" xmlns="http://www.w3.org/2000/svg" style="position: absolute;">
                            <line x1="0" y1="0" x2="320" y2="240" stroke-width="4" stroke="black"></line>
                        </svg>
                    @endif
                    <div class="hand-row">
                        <div class="north hand">
                            <ul>
                                @foreach($hands['n'] as $k => $line)
                                    <li class="suit suit{{$k}}">{{$line}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="hand-row is-clearfix">
                        <div class="west hand">
                            <ul>
                                @foreach($hands['w'] as $k => $line)
                                    <li class="suit suit{{$k}}">{{$line}}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="east hand">
                            <ul>
                                @foreach($hands['e'] as $k => $line)
                                    <li class="suit suit{{$k}}">{{$line}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="hand-row">
                        <div class="south hand">
                            <ul>
                                @foreach($hands['s'] as $k => $line)
                                    <li class="suit suit{{$k}}">{{$line}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="auction">
                    <h2 class="title is-4">Auction</h2>

                    <div class="columns is-mobile auction-header {{$appeal->board->vul}}">
                        <div class="column n has-text-centered">North</div>
                        <div class="column w has-text-centered">East</div>
                        <div class="column s has-text-centered">South</div>
                        <div class="column w has-text-centered">West</div>
                    </div>

                    <div id="auction">
                        @foreach($auction as $k => $bid)
                            @if($k % 4 === 0)
                                <div class="columns is-mobile auction-row auction-row__{{$row++}}">
                                    @endif
                                    <div class="column is-one-quarter has-text-centered @if(array_key_exists($bid, $alerts) === true) alerted-bid @endif" data-bid="{{$bid}}">
                                        {{strtoupper($bid)}}
                                    </div>
                                    @if($k % 4 === 3)
                                </div>
                            @endif
                        @endforeach

                        {{-- End with a correct closing tag--}}
                        @if($row*4 > $k && $k % 4 !== 3)
                        </div>
                        @endif
                    </div>

                </div>

                @if($alerts)
                    <div class="alerts">
                        <ul>
                            @foreach($alerts as $alert => $explanation)
                                <li><strong>{{$alert}}</strong>: {{$explanation}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="column is-7">
                <div class="content">
                    <p class="subtitle">{{$appeal->appeal_time->toFormattedDateString()}}</p>

                    <p>
                        <strong>Level</strong>: {{$appeal->event->level}} <br>
                        <strong>NBO</strong>: {{$appeal->event->nbo}} <br>
                        <strong>Category</strong>: {{config('bridge.categories')[$appeal->category_id]}} <br>
                        <strong>Scoring</strong>: {{config('bridge.scoring')[$appeal->scoring_id]}}
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

                    <p>
                        <strong>Table Result</strong>: {{$appeal->board->table_result}}<br>
                        <strong>Lead</strong>:{{$appeal->board->lead}}
                    </p>
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

        <div class="columns">
            <div class="column has-text-centered">
                <small>This document was created at <strong>{{$appeal->created_at->format('F j, Y - G:i')}}</strong>
                    @if($appeal->created_at->ne($appeal->updated_at))
                        and last updated at <strong>{{$appeal->updated_at->format('F j, Y - G:i')}}</strong>
                    @endif
                </small>
            </div>
        </div>
    </div>
{{--{{dd($appeal)}}--}}
@endsection