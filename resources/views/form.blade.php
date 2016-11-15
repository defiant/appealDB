@extends('layouts.app')

@push('css')
    <link href="/css/flatpickr.min.css" rel="stylesheet">
@endpush

@push('js')
    <script src="/js/jquery.min.js"></script>
    <script src="/js/flatpickr.min.js"></script>
    <script src="/js/bidding-helper.js"></script>
    <script>
        document.getElementById("appeal_date").flatpickr({
            maxDate: "today",
            altInput: true,
            altInputClass: 'input'
        });
    </script>
@endpush

@section('title')Create New Entry @endsection

@section('content')
    <div class="container">
        <div class="column is-10 is-offset-1">
            <form action="/store" method="post" id="appeal_form">
                <fieldset>
                    <legend>Event Info</legend>
                    <div class="columns">
                        <div class="column">
                            <label for="event_name" class="label">Event Name:</label>
                            <p class="control">
                                <input type="text" name="event_name" id="event_name" class="input" placeholder="Event Name" required>
                            </p>
                        </div>

                        <div class="column">
                            <label for="event_session" class="label">Session</label>
                            <p class="control">
                                <input type="text" name="event_session" id="event_session" class="input" placeholder="Session or Match" required>
                            </p>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <label for="nbo" class="label">Bridge Organization</label>
                            <p class="control">
                                <input type="text" name="nbo" id="nbo" class="input" placeholder="NBO: ACBL, EBL etc..">
                            </p>
                        </div>

                        <div class="column">
                            <label for="scoring" class="label">Scoring</label>
                            <p class="control">
                                <span class="select is-fullwidth">
                                    <select id="id_scoring" name="scoring">
                                        @foreach(config('bridge.scoring') as $key => $score)
                                            <option value="{{$key}}">{{$score}}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </p>
                        </div>

                        <div class="column">
                            <label for="event_level" class="label">Event Level</label>
                            <p class="control">
                                <span class="select is-fullwidth">
                                    <select name="event_level" id="event_level">
                                        <option value="international">International</option>
                                        <option value="national">National</option>
                                        <option value="regional">Regional</option>
                                        <option value="local">Local (Club)</option>
                                    </select>
                                </span>
                            </p>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>General Information</legend>

                    <div class="columns">
                        <div class="column">
                            <label for="appeal_date" class="label">Appeal Date</label>
                            <p class="control has-icon">
                                <input type="text" name="date" id="appeal_date" class="input" placeholder="Click to Select a Date">
                                <i class="fa fa-calendar"></i>
                            </p>
                        </div>

                        <div class="column">
                            <label for="appeal_category" class="label">Appeal Category</label>
                            <p class="control">
                                <span class="select is-fullwidth">
                                    <select name="appeal_category" id="appeal_category">
                                        @foreach(config('bridge.categories') as $k => $category)
                                            <option value="{{$k}}">{{$category}}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </p>
                        </div>

                        <div class="column">
                            <label for="casebook" class="label">Casebook Name</label>
                            <p class="control">
                                <input type="text" name="casebook" id="casebook" class="input" placeholder="Casebook name or reference if available">
                            </p>
                        </div>
                    </div>

                    <hr>
                    <div class="columns">
                        <div class="column">
                            <label for="player_north" class="label">North Player</label>
                            <p class="control">
                                <input type="text" name="player_north" id="player_north" class="input" placeholder="Name of the player at north position">
                            </p>
                        </div>
                        <div class="column">
                            <label for="player_south" class="label">South Player</label>
                            <p class="control">
                                <input type="text" name="player_south" id="player_south" class="input" placeholder="Name of the player at south position">
                            </p>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <label for="player_east" class="label">East Player</label>
                            <p class="control">
                                <input type="text" name="player_east" id="player_east" class="input" placeholder="Name of the player at east position">
                            </p>
                        </div>
                        <div class="column">
                            <label for="player_west" class="label">West Player</label>
                            <p class="control">
                                <input type="text" name="player_west" id="player_west" class="input" placeholder="Name of the player at west position">
                            </p>
                        </div>
                    </div>

                    <label class="label">Appealing Side</label>
                    <p class="control">
                        <label class="radio">
                            <input type="radio" value="ns" name="side_appealing">
                            North/South
                        </label>
                        <label class="radio">
                            <input type="radio" value="ew" name="side_appealing">
                            East/West
                        </label>
                        {{--<label class="radio">
                            <input type="radio" value="" name="side_appealing">
                            NA
                        </label>--}}
                    </p>

                    <label for="director" class="label">Director</label>
                    <p class="control">
                        <input type="text" name="director" id="director" class="input" placeholder="Director's name">
                    </p>

                    <label for="committee" class="label">Appeal Committe</label>
                    <p class="control">
                        <input type="text" name="committee" id="committee" class="input" placeholder="Name of AC Members separated by comma">
                    </p>

                    <div class="columns">
                        <div class="column">
                            <label for="facts" class="label">Facts</label>
                            <p class="control">
                                <textarea name="facts" id="facts" cols="30" rows="10" class="textarea"></textarea>
                            </p>

                            <label for="ruling" class="label">Ruling</label>
                            <p class="control">
                                <textarea name="ruling" id="ruling" cols="30" rows="10" class="textarea" placeholder="The Ruling of the director"></textarea>
                            </p>

                            <label for="appeal_reason" class="label">Appeal Reason</label>
                            <p class="control">
                                <textarea name="appeal_reason" id="appeal_reason" cols="30" rows="10" class="textarea" placeholder="Why did this hand appealed?"></textarea>
                            </p>

                            <label for="decision" class="label">Decision</label>
                            <p class="control">
                                <textarea name="decision" id="decision" cols="30" rows="10" class="textarea" placeholder="Decision of the Appeal Committee"></textarea>
                            </p>
                        </div>
                        <div class="column is-4">
                            <div class="content">
                                <p>&nbsp;</p>
                                <p>These four text fields support markdown. This means you can apply some styling. For markdown reference you can check this
                                    <a href="https://daringfireball.net/projects/markdown/basics">link</a>.</p>
                                <p>Also you can use native suit symbols: <br>(♠, ♥,  ♦, ♣) <br>If you don't have easy access to these symbols you can also use BBO style suits; (!S, !H, !D, !C) They will be converted to their respective symbols once the record is saved.</p>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <label class="label">Ruling Upheld?</label>
                            <p class="control">
                                <label class="radio">
                                    <input type="radio" value="1" name="ruling_upheld">
                                    Yes
                                </label>
                                <label class="radio">
                                    <input type="radio" value="0" name="ruling_upheld">
                                    No
                                </label>
                            </p>
                        </div>
                        <div class="column is-9">
                            Did the Appeal Committee upheld the director's ruling? If yes check this box. It will help us better categorize appeals.
                        </div>
                    </div>

                    <label for="laws" class="label">Relevant Laws</label>
                    <p class="control">
                        <input type="text" name="laws" id="laws" class="input" placeholder="Relevant laws separated by comma; 40A, 62B">
                    </p>
                </fieldset>

                <fieldset>
                    <legend>Board Information</legend>

                    <div class="columns">
                        <div class="column">
                            <label for="board_no" class="label">Board Number</label>
                            <p class="control">
                                <input type="number" name="board_no" id="board_no" class="input" placeholder="Board NO" min="1" required>
                            </p>
                        </div>
                        <div class="column">
                            <label for="dealer" class="label">Dealer</label>
                            <p class="control">
                                <span class="select">
                                    <select name="dealer" id="dealer">
                                        <option value="0">North</option>
                                        <option value="1">East</option>
                                        <option value="2">South</option>
                                        <option value="3">West</option>
                                    </select>
                                </span>
                            </p>
                        </div>
                        <div class="column">
                            <label for="vul" class="label">Vulnerability</label>
                            <p class="control">
                                <span class="select">
                                    <select name="vul" id="vul">
                                        <option value="none">None</option>
                                        <option value="ew">East / West</option>
                                        <option value="ns">North / South</option>
                                        <option value="all">All</option>
                                    </select>
                                </span>
                            </p>
                        </div>
                        <div class="column">
                            <label for="" class="label">Screen?</label>
                            <p class="control">
                                <label class="checkbox">
                                    <input type="checkbox" name="screen" id="screen">
                                    Screen present?
                                </label>
                            </p>
                        </div>
                    </div>

                    <hr>
                    <h1 class="title is-3">Hands</h1>
                    <div class="columns">
                        <div class="column is-8-desktop">
                            <div id="hand_diagram" class="hand_digram">
                                <div class="columns">
                                    <div class="column is-one-third"></div>
                                    <div class="column is-one-third hand-input" id="hand-north">
                                        <p>North</p>
                                        <input type="text" name="deal[n][s]" id="deal[n][s]" class="input" placeholder="♠">
                                        <input type="text" name="deal[n][h]" id="deal[n][h]" class="input" placeholder="♥">
                                        <input type="text" name="deal[n][d]" id="deal[n][d]" class="input" placeholder="♦">
                                        <input type="text" name="deal[n][c]" id="deal[n][c]" class="input" placeholder="♣">
                                    </div>
                                    <div class="column is-one-third"></div>
                                </div>
                                <div class="columns">
                                    <div class="column is-one-third hand-input" id="hand-west">
                                        <p>West</p>
                                        <input type="text" name="deal[w][s]" id="deal[w][s]" class="input" placeholder="♠">
                                        <input type="text" name="deal[w][h]" id="deal[w][h]" class="input" placeholder="♥">
                                        <input type="text" name="deal[w][d]" id="deal[w][d]" class="input" placeholder="♦">
                                        <input type="text" name="deal[w][c]" id="deal[w][c]" class="input" placeholder="♣">
                                    </div>

                                    <div class="column is-one-third">
                                        <div class="notification is-danger" id="too_many_cards">
                                            The hand with the red box has more than 13 cards.
                                        </div>
                                    </div>

                                    <div class="column is-one-third hand-input" id="hand-east">
                                        <p>East</p>
                                        <input type="text" name="deal[e][s]" id="deal[e][s]" class="input" placeholder="♠">
                                        <input type="text" name="deal[e][h]" id="deal[e][h]" class="input" placeholder="♥">
                                        <input type="text" name="deal[e][d]" id="deal[e][d]" class="input" placeholder="♦">
                                        <input type="text" name="deal[e][c]" id="deal[e][c]" class="input" placeholder="♣">
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column is-one-third"></div>
                                    <div class="column is-one-third hand-input" id="hand-south">
                                        <p>South</p>
                                        <input type="text" name="deal[s][s]" id="deal[s][s]" class="input" placeholder="♠">
                                        <input type="text" name="deal[s][h]" id="deal[s][h]" class="input" placeholder="♥">
                                        <input type="text" name="deal[s][d]" id="deal[s][d]" class="input" placeholder="♦">
                                        <input type="text" name="deal[s][c]" id="deal[s][c]" class="input" placeholder="♣">
                                    </div>
                                    <div class="column is-one-third"></div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="content">
                                <p>
                                    Acceptable characters;
                                </p>
                                <ul>
                                    <li>A for Ace</li>
                                    <li>K for King</li>
                                    <li>Q for Queen</li>
                                    <li>J for Jack</li>
                                    <li>T fot Ten</li>
                                </ul>
                                <p>
                                    Numbers [2..9] <br><br>
                                    The order of the cards does not matter. Also uppercase or lowercase won't matter, we will convert them for you.
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h3 class="title is-3">Bidding</h3>
                    <div class="columns">
                        <div class="column is-4 is-mobile">
                            <div class="bidding_box" id="bidding_box">
                                <div class="calls">
                                    <div data-bid-string="P" class="call_card pass">Pass</div>
                                    <div data-bid-string="X" class="call_card double disabled">Double</div>
                                    <div data-bid-string="XX" class="call_card redouble disabled">Redouble</div>
                                </div>

                                <div class="bids">
                                    <div class="bid_row">
                                        <div data-bid-string="1C" class="bid_card clubs">1♣</div>
                                        <div data-bid-string="1D" class="bid_card diamonds">1♦</div>
                                        <div data-bid-string="1H" class="bid_card hearts">1♥</div>
                                        <div data-bid-string="1S" class="bid_card spades">1♠</div>
                                        <div data-bid-string="1N" class="bid_card notrump">1NT</div>
                                    </div>
                                    <div class="bid_row">
                                        <div data-bid-string="2C" class="bid_card clubs">2♣</div>
                                        <div data-bid-string="2D" class="bid_card diamonds">2♦</div>
                                        <div data-bid-string="2H" class="bid_card hearts">2♥</div>
                                        <div data-bid-string="2S" class="bid_card spades">2♠</div>
                                        <div data-bid-string="2N" class="bid_card notrump">2NT</div>
                                    </div>
                                    <div class="bid_row">
                                        <div data-bid-string="3C" class="bid_card clubs">3♣</div>
                                        <div data-bid-string="3D" class="bid_card diamonds">3♦</div>
                                        <div data-bid-string="3H" class="bid_card hearts">3♥</div>
                                        <div data-bid-string="3S" class="bid_card spades">3♠</div>
                                        <div data-bid-string="3N" class="bid_card notrump">3NT</div>
                                    </div>
                                    <div class="bid_row">
                                        <div data-bid-string="4C" class="bid_card clubs">4♣</div>
                                        <div data-bid-string="4D" class="bid_card diamonds">4♦</div>
                                        <div data-bid-string="4H" class="bid_card hearts">4♥</div>
                                        <div data-bid-string="4S" class="bid_card spades">4♠</div>
                                        <div data-bid-string="4N" class="bid_card notrump">4NT</div>
                                    </div>
                                    <div class="bid_row">
                                        <div data-bid-string="5C" class="bid_card clubs">5♣</div>
                                        <div data-bid-string="5D" class="bid_card diamonds">5♦</div>
                                        <div data-bid-string="5H" class="bid_card hearts">5♥</div>
                                        <div data-bid-string="5S" class="bid_card spades">5♠</div>
                                        <div data-bid-string="5N" class="bid_card notrump">5NT</div>
                                    </div>
                                    <div class="bid_row">
                                        <div data-bid-string="6C" class="bid_card clubs">6♣</div>
                                        <div data-bid-string="6D" class="bid_card diamonds">6♦</div>
                                        <div data-bid-string="6H" class="bid_card hearts">6♥</div>
                                        <div data-bid-string="6S" class="bid_card spades">6♠</div>
                                        <div data-bid-string="6N" class="bid_card notrump">6NT</div>
                                    </div>
                                    <div class="bid_row">
                                        <div data-bid-string="7C" class="bid_card clubs">7♣</div>
                                        <div data-bid-string="7D" class="bid_card diamonds">7♦</div>
                                        <div data-bid-string="7H" class="bid_card hearts">7♥</div>
                                        <div data-bid-string="7S" class="bid_card spades">7♠</div>
                                        <div data-bid-string="7N" class="bid_card notrump">7NT</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-3">

                            <div class="columns">
                                <div class="column">

                                    <div class="bidding-diagram" id="bidding-diagram">
                                        <div class="diagram-header auction-header none">
                                            <div class="n">N</div>
                                            <div class="e">E</div>
                                            <div class="s">S</div>
                                            <div class="w">W</div>
                                        </div>

                                        <div class="bidding_wrapper">
                                            <div class="bidding" id="bidding">

                                            </div>
                                        </div>

                                        <div class="undo_button is-clearfix">
                                            <button id="undo" class="button is-fullwidth is-disabled" type="button">Undo Last Bid</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="column">
                            <div class="notification">
                                <button class="delete" type="button"></button>
                                If you want to alert or explain a bid. You can click on the bid you want to explain to show the alert box!
                            </div>
                            <div class="columns">
                                <div id="alerts">

                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <div class="explain_bid" id="explain_bid">
                                        <label for="explain_bid_input" class="label">Explain Bid <span></span></label>
                                        <p class="control">
                                            <input type="text" class="input" id="explain_bid_input">
                                        </p>
                                        <p class="control">
                                            <button type="button" class="button is-small" id="save_alert">Ok</button>
                                            <button type="button" class="button is-small" id="cancel_alert">Cancel</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--<div class="column is-4">
                            <div class="content">
                                <p>
                                    All bids are separated by a white space.
                                </p>
                                <ul>
                                    <li>Pass => P</li>
                                    <li>Double => X</li>
                                    <li>Redouble => XX</li>
                                    <li>No Trump => n</li>
                                    <li>Clubs => c</li>
                                    <li>Diamonds => d</li>
                                    <li>Hearts => h</li>
                                    <li>Spades => s</li>
                                </ul>

                                <p>A valid bid for a suit is a two character string. For example 1&hearts; is represented as 1h. And one no trump as 1n</p>
                                <p>If you need to alert a bid you can put a ! (exclamation) character. Ie: 2c!</p>
                            </div>
                        </div>--}}
                    </div>

                    {{--<hr>
                    <div class="columns">
                        <div class="column is-8">
                            <label for="alerts" class="label">Alerts</label>
                            <p class="control">
                                <textarea name="alerts" id="alerts" cols="30" rows="10" class="textarea"></textarea>
                            </p>
                        </div>
                        <div class="column is-4">
                            <div class="content">
                                <p>
                                    If you made an alert at the previous bidding section you can use this section to explain the alerted bid.
                                    All you have to do is to start the explanation with a ! character. If you need to add more than one explanation just start each explanation with an !
                                    <br>
                                    <strong>Just don't use ! except starting an explanation.</strong>
                                </p>
                            </div>
                        </div>
                    </div>--}}

                    <hr>
                    <div class="columns">
                        <div class="column is-3">
                            <label for="table_result" class="label">Table Result</label>
                            <p class="control">
                                <input type="text" name="table_result" id="table_result" class="input" maxlength="6">
                            </p>

                            <label for="lead" class="label">Lead</label>
                            <p class="control">
                                <input type="text" name="lead" id="lead" class="input" maxlength="2">
                            </p>
                        </div>

                        <div class="column">
                            <div class="content">
                                <p>
                                    <strong>Table Result</strong>: If a normal result is obtained at the table, enter it here. The format is consistent. First character is level of play, second is the suit, if doubled or redoubled enter an <strong>X</strong>(or <strong>XX</strong> for redouble) and finally as result '<strong>=</strong>', '<strong>+2</strong>', '<strong>-1</strong>'.
                                    <ul>
                                        <li><strong>4hx=</strong> 4 hearts doubled, just made</li>
                                        <li><strong>3s-2</strong> 3 spades, down 2</li>
                                        <li><strong>1n+2</strong> 1 no trump, plus 2</li>
                                    </ul>
                                </p>
                                <p>
                                    <strong>Lead</strong> is a two character entry suit char (as explained in the bidding section). and the single number card value as explained in the hand entry section. Ie: <strong>c8</strong> for eight of clubs.<br>
                                </p>
                            </div>
                        </div>
                    </div>

                </fieldset>

                {{--Auction data is saved to this form element--}}
                <input type="hidden" name="bidding" id="bidding-data">

                <p class="control">
                    <button class="button is-primary is-fullwidth" type="submit" id="submit">Save this appeal!</button>
                </p>
                {{csrf_field()}}
            </form>
        </div>
    </div>

@endsection