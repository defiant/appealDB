@extends('layouts.app')

@section('title'){{$appeal->event->event_name}} appeal records - AppealDB.com @endsection

@section('meta_description')Appeal records for the event {{$appeal->event->event_name}} ({{$appeal->event->session}}) concerning {{config('bridge.categories')[$appeal->category_id]}} at board {{$appeal->board->board_no}}. The appeal was at {{$appeal->appeal_time->toFormattedDateString()}}. @if($appeal->laws) Related laws: {{$appeal->laws}} @endif @endsection

@section('content')

    <section class="section">
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
                    <div class="hand-info columns is-mobile has-text-centered">
                        <div class="column"><strong>Board No</strong>: {{$appeal->board->board_no}}</div>
                        <div class="column"><strong>Dealer</strong>: {{config('bridge.dealer')[$appeal->board->dealer]}}</div>
                        <div class="column"><strong>Vulnerable</strong>: {{strtoupper($appeal->board->vul)}}</div>
                    </div>

                    <div class="hand-diagram">
                        @if($appeal->board->screen)
                            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" style="position: absolute; z-index: 10;">
                                <line id="screen-line" x1="0" y1="0" x2="100%" y2="100%" stroke-width="2" stroke="black"></line>
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

                    @if($auction)
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
                                            <div class="column is-one-quarter has-text-centered @if($alerts && array_key_exists($k - $appeal->board->dealer, $alerts) === true) alerted-bid @endif" data-bid-index="{{$k - $appeal->board->dealer}}">
                                                {{$bid}}
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
                @endif

                @if($alerts)
                    <div class="alerts">
                        <ul>
                            @foreach($alerts as $k => $explanation)
                                <li id="alert-{{$k}}">{{$explanation}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="column is-7">
                <div class="content">
                    <p>
                        <strong>Appeal Date</strong>: {{$appeal->appeal_time->format('F jS, Y (l)')}} <br>
                        @if($appeal->casebook) <strong>Casebook Name</strong>: {{$appeal->casebook}} <br> @endif
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
                        @if($appeal->board->table_result)<strong>Table Result</strong>: @result($appeal->board->table_result). <em>({{$appeal->board->table_result}})</em><br>@endif
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
                    <small>This document was created at <strong>{{$appeal->created_at->format('F j, Y (T) - H:i')}}</strong>
                        @if($appeal->created_at->ne($appeal->updated_at))
                            and last updated at <strong>{{$appeal->updated_at->format('F j, Y (T) - H:i')}}</strong>
                        @endif
                    </small>
                    <hr>
                </div>
            </div>

            <div class="columns">
                <div class="column is-10 is-offset-1">
                    <h2 class="title">Discussion</h2>
                    <div id="disqus_thread"></div>
                    <script>
                        /*
                         var disqus_config = function () {
                         this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                         this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                         };
                         */
                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document, s = d.createElement('script');
                            s.src = '//appealdb.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                </div>
            </div>
        </div>
    </section>

@endsection