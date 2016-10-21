@extends('layouts.app')

@push('css')
    <link href="/css/flatpickr.min.css" rel="stylesheet">
@endpush

@push('js')
    <script src="/js/flatpickr.min.js"></script>
    <script>
        document.getElementById("appeal_date").flatpickr({
            altInput: true,
            altInputClass: 'input'
        });
    </script>
@endpush

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
                                <input type="text" name="event_session" id="event_session" class="input" placeholder="Session" required>
                            </p>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <label for="nbo" class="label">National Bridge Organization</label>
                            <p class="control">
                                <input type="text" name="nbo" id="nbo" class="input" placeholder="NBO: ACBL, EBL etc..">
                            </p>
                        </div>

                        <div class="column">
                            <label for="event_level" class="label">Event Level</label>
                            <p class="control">
                            <span class="select">
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
                    <legend>Info</legend>

                    <div class="columns">
                        <div class="column">
                            <label for="appeal_date" class="label">Appeal Date</label>
                            <p class="control has-icon">
                                <input type="text" name="date" id="appeal_date" class="input" placeholder="Click to Select a Date">
                                <i class="fa fa-calendar"></i>
                            </p>
                        </div>
                        <div class="column">
                            <label for="appeal_category" class="label">Appeal Caegory</label>
                            <p class="control">
                                <span class="select">
                                    <select name="appeal_category" id="appeal_category">
                                        <option value="0">Misinformation</option>
                                        <option value="1">Unauthorised Information</option>
                                        <option value="1">Tempo, Break in Tempo</option>
                                        <option value="2">Illegal Deception</option>
                                        <option value="3">Contested or Disputed Claim</option>
                                        <option value="4">Inadvertent call</option>
                                        <option value="5">Revoke</option>
                                    </select>
                                </span>
                            </p>
                        </div>
                    </div>

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

                    <label for="director" class="label">Director</label>
                    <p class="control">
                        <input type="text" name="director" id="director" class="input" placeholder="Director's name">
                    </p>

                    <label for="committee" class="label">Appeal Committe</label>
                    <p class="control">
                        <input type="text" name="committee" id="committee" class="input" placeholder="Name of AC Members separated by comma">
                    </p>

                    <label for="facts" class="label">Facts</label>
                    <p class="control">
                        <textarea name="facts" id="facts" cols="30" rows="10" class="textarea"></textarea>
                    </p>

                    <label for="ruling" class="label">Ruling</label>
                    <p class="control">
                        <textarea name="ruling" id="ruling" cols="30" rows="10" class="textarea"></textarea>
                    </p>

                    <label for="appeal_reason" class="label">Appeal Reason</label>
                    <p class="control">
                        <textarea name="appeal_reason" id="appeal_reason" cols="30" rows="10" class="textarea"></textarea>
                    </p>

                    <label for="decision" class="label">Decision</label>
                    <p class="control">
                        <textarea name="decision" id="decision" cols="30" rows="10" class="textarea"></textarea>
                    </p>

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
                                <input type="number" name="board_no" id="board_no" class="input" placeholder="Board NO">
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
                                    <div class="column is-one-third">
                                        <p>North</p>
                                        <input type="text" name="deal[n][s]" id="deal[n][s]" class="input" placeholder="♠">
                                        <input type="text" name="deal[n][h]" id="deal[n][h]" class="input" placeholder="♥">
                                        <input type="text" name="deal[n][d]" id="deal[n][d]" class="input" placeholder="♦">
                                        <input type="text" name="deal[n][c]" id="deal[n][c]" class="input" placeholder="♣">
                                    </div>
                                    <div class="column is-one-third"></div>
                                </div>
                                <div class="columns">
                                    <div class="column is-one-third">
                                        <p>West</p>
                                        <input type="text" name="deal[w][s]" id="deal[w][s]" class="input" placeholder="♠">
                                        <input type="text" name="deal[w][h]" id="deal[w][h]" class="input" placeholder="♥">
                                        <input type="text" name="deal[w][d]" id="deal[w][d]" class="input" placeholder="♦">
                                        <input type="text" name="deal[w][c]" id="deal[w][c]" class="input" placeholder="♣">
                                    </div>

                                    <div class="column is-one-third"></div>

                                    <div class="column is-one-third">
                                        <p>East</p>
                                        <input type="text" name="deal[e][s]" id="deal[e][s]" class="input" placeholder="♠">
                                        <input type="text" name="deal[e][h]" id="deal[e][h]" class="input" placeholder="♥">
                                        <input type="text" name="deal[e][d]" id="deal[e][d]" class="input" placeholder="♦">
                                        <input type="text" name="deal[e][c]" id="deal[e][c]" class="input" placeholder="♣">
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column is-one-third"></div>
                                    <div class="column is-one-third">
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
                    <div class="columns">
                        <div class="column is-8">
                            <label for="bidding" class="label">Bidding</label>
                            <p class="control">
                                <textarea name="bidding" id="bidding" cols="30" rows="10" class="textarea"></textarea>
                            </p>
                        </div>
                        <div class="column is-4">
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
                        </div>
                    </div>

                    <hr>
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
                    </div>

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

                {{csrf_field()}}

                <p class="control">
                    <button class="button is-primary is-fullwidth">Save this appeal!</button>
                </p>
            </form>
        </div>
    </div>

@endsection