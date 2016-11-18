@extends('layouts.app')

@section('title') AppealDB - Database for Bridge Appeals @endsection
@section('meta_description') An online database for Bridge Appeals where you can view and discuss appeal decision from various tournaments.@endsection

@section('content')
    <div class="container">
        <h1 class="title is-1">AppealDB</h1>
        <p class="subtitle">
            A database for Bridge Appeals
        </p>

        <hr>
        <div class="columns">
            <div class="column is-8">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Event</th>
                        <th>Category</th>
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
                            <td>{{config('bridge.categories')[$appeal->category_id]}}</td>
                            <td>{{$appeal->appeal_time->toFormattedDateString()}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="column">
                <div class="content">
                    <h2>What and Why?</h2>
                    <p>
                        <strong>AppealDB</strong> is a an online archive for Bridge Appeals. <br>
                        The reason for this application is store various appeals decision so it can be referenced and discussed.
                    </p>

                    <h2>How can you help?</h2>
                    <h3>By adding content</h3>
                    <p>
                        You can help by adding Appeal decisions. But keep in mind that for this project to be useful it needs correct data and volunteers. So if you have access to appeals or you are the side of a receent appeal, you can use this project to add your appeal details.
                    </p>

                    <h3>By coding</h3>
                    <p>
                        If you have coding skills you can contribute to the project. It will be open sourced very soon.
                    </p>

                    <a href="/create" class="button is-danger is-fullwidth">Add an Appeal now</a>
                </div>
            </div>
        </div>
    </div>
@endsection
