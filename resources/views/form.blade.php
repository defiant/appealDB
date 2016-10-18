@extends('layouts.app')

@section('content')
    <div class="column">
        <form action="/store" method="post">
            <fieldset>
                <legend>Event Info</legend>

                <label for="event_name" class="label">Event Name:</label>
                <p class="control">
                    <input type="text" name="event_name" id="event_name" class="input" placeholder="Event Name" required>
                </p>

                <label for="event_session" class="label">Session</label>
                <p class="control">
                    <input type="text" name="event_session" id="event_session" class="input" placeholder="Session" required>
                </p>

                <label for="event_level" class="label">Event Level</label>
                <p class="control">
                    <span class="select">
                        <select name="event_level" id="event_level">
                            <option value="local">Local</option>
                            <option value="regional">Regional</option>
                            <option value="national">National</option>
                            <option value="international">International</option>
                        </select>
                    </span>
                </p>

                <label for="nbo" class="label">National Bridge Organization</label>
                <p class="control">
                    <input type="text" name="nbo" id="nbo" class="input" placeholder="NBO: ACBL, EBL etc..">
                </p>
            </fieldset>

            <fieldset>
                <legend>Info</legend>

                <label for="date" class="label">Appeal Date</label>
                <p class="control">
                    <input type="text" name="date" id="date" class="input">
                </p>

                <label for="player_north" class="label">North Player</label>
                <p class="control">
                    <input type="text" name="player_north" id="player_north" class="input" placeholder="Name of the player at north position">
                </p>

                <label for="player_south" class="label">South Player</label>
                <p class="control">
                    <input type="text" name="player_south" id="player_south" class="input" placeholder="Name of the player at south position">
                </p>

                <label for="player_east" class="label">East Player</label>
                <p class="control">
                    <input type="text" name="player_east" id="player_east" class="input" placeholder="Name of the player at east position">
                </p>

                <label for="player_west" class="label">West Player</label>
                <p class="control">
                    <input type="text" name="player_west" id="player_west" class="input" placeholder="Name of the player at west position">
                </p>

                <label for="director" class="label">Director</label>
                <p class="control">
                    <input type="text" name="director" id="director" class="input" placeholder="Director's name">
                </p>

                <label for="committee" class="label">Appeal Committe</label>
                <p class="control">
                    <input type="text" name="committee" id="committee" class="input" placeholder="Name of AC Members separated by comma">
                </p>

                <label for="facts" class="label">Ruling</label>
                <p class="control">
                    <textarea name="facts" id="facts" cols="30" rows="10" class="textarea"></textarea>
                </p>

                <label for="appeal_reason" class="label">Appeal Reason</label>
                <p class="control">
                    <textarea name="appeal_reason" id="appeal_reason" cols="30" rows="10" class="textarea"></textarea>
                </p>

                <label for="decision" class="label">Decision</label>
                <p class="control">
                    <textarea name="decision" id="decision" cols="30" rows="10" class="textarea"></textarea>
                </p>
            </fieldset>

            <fieldset>
                <legend>Board Information</legend>

                <div class="columns">
                    <div class="column">
                        <label for="board_no" class="label">Board Number</label>
                        <p class="control">
                            <input type="number" name="board_no" id="board_no" class="input">
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
                </div>


                <p class="control">
                    <label class="checkbox">
                        <input type="checkbox" name="screen">
                        Screen present?
                    </label>
                </p>

                <div id="hand_digram" class="hand_digram">
                    <div class="columns">
                        <div class="column is-one-third"></div>
                        <div class="column is-one-third">
                            <input type="text" name="deal[n][s]" id="deal[n][s]" class="input">
                            <input type="text" name="deal[n][h]" id="deal[n][h]" class="input">
                            <input type="text" name="deal[n][d]" id="deal[n][d]" class="input">
                            <input type="text" name="deal[n][c]" id="deal[n][c]" class="input">
                        </div>
                        <div class="column is-one-third"></div>
                    </div>
                    <div class="columns">
                        <div class="column is-one-third">
                            <input type="text" name="deal[w][s]" id="deal[w][s]" class="input">
                            <input type="text" name="deal[w][h]" id="deal[w][h]" class="input">
                            <input type="text" name="deal[w][d]" id="deal[w][d]" class="input">
                            <input type="text" name="deal[w][c]" id="deal[w][c]" class="input">
                        </div>

                        <div class="column is-one-third"></div>

                        <div class="column is-one-third">
                            <input type="text" name="deal[e][s]" id="deal[e][s]" class="input">
                            <input type="text" name="deal[e][h]" id="deal[e][h]" class="input">
                            <input type="text" name="deal[e][d]" id="deal[e][d]" class="input">
                            <input type="text" name="deal[e][c]" id="deal[e][c]" class="input">
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-one-third"></div>
                        <div class="column is-one-third">
                            <input type="text" name="deal[s][s]" id="deal[s][s]" class="input">
                            <input type="text" name="deal[s][h]" id="deal[s][h]" class="input">
                            <input type="text" name="deal[s][d]" id="deal[s][d]" class="input">
                            <input type="text" name="deal[s][c]" id="deal[s][c]" class="input">
                        </div>
                        <div class="column is-one-third"></div>
                    </div>
                </div>

                <label for="bidding" class="label">Bidding</label>
                <p class="control">
                    <textarea name="bidding" id="bidding" cols="30" rows="10" class="textarea"></textarea>
                </p>

                <label for="alerts" class="label">Alerts</label>
                <p class="control">
                    <textarea name="alerts" id="alerts" cols="30" rows="10" class="textarea"></textarea>
                </p>

            </fieldset>

            {{csrf_field()}}

            <p class="control">
                <button class="button is-primary is-fullwidth">Save this appeal!</button>
            </p>
        </form>
    </div>

@endsection