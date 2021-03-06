@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex align-items-center">
                        <h2>All Questions</h2>

                        <div class="ml-auto">
                            @if (Auth::user())
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Question</a>
                            @endif
                        </div>

                    </div>

                </div>

                <div class="card-body">

                    {{-- Include the _message blade file, when question is submitted, if success, then will display the message stored in sesison --}}
                    @include ('layouts._message')

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
                                <div class="d-flex align-items-center">
                                    <h3 class="mt-0">
                                        {{-- href address will go to Question Model::getUrlAttribute function --}}
                                        <a href="{{ $question->url }}">{{ $question->title }}</a>
                                    </h3>
                                    <div class="ml-auto"> {{-- margin left auto class --}}
                                        @can('update', $question)
                                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan
                                        @can('delete', $question)
                                        <form class="form-delete" action="{{ route('questions.destroy', $question->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>


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
