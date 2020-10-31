@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Questions</div>

                <div class="card-body">

                    @foreach ($questions as $question)
                        <div class="media">
                            <div class="d-flex flex-column counters">
                                {{-- hold the numbers of vote --}}
                                <div class="vote">
                                    <strong>{{ $question->votes }}</strong> {{ Str::plural('vote', $question->votes) }}
                                </div>

                                {{-- status is depends on the value passed from database,use accesor in Question model to modify the return value, then applied the CSS --}}
                                <div class="status {{ $question->status }}">
                                    <strong>{{ $question->answers }}</strong> {{ Str::plural('answer', $question->answers) }}
                                </div>

                                <div class="view">
                                    {{ $question->views . " " . Str::plural('view', $question->views) }}
                                </div>

                            </div>

                            <div class="media-body">
                                <h3 class="mt-0">
                                    {{-- href address will go to Question Model::getUrlAttribute function --}}
                                    <a href="{{ $question->url }}">{{ $question->title }}</a>
                                </h3>

                                <p class="lead">
                                    Asked by
                                    {{-- href address will go to User Model::getUrlAttribute function --}}
                                    <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>

                                    {{-- href address will go to Question Model::getCreatedDateAttribute function --}}
                                    <small class="textt-muted">{{ $question->created_date }}</small>
                                </p>

                                {{-- limit the question text length --}}
                                {{ Str::limit($question->body, 250) }}

                            </div>
                        </div>

                        <hr>
                    @endforeach

                    {{-- This is the pagination component --}}
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
