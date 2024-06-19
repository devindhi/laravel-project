<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
@extends('layout')
@section('title', 'blog')
@section('content')
    @include('components.alert')
    <div class="flex justify-center items-center flex-col">
        <a href="{{ url('/') }}">
            <button type="button" class="btn btn-success m-4"><i class="bi bi-skip-backward-fill"></i></button>
        </a>
        <div class="container">
            <h2 class="text-3xl font-bold mb-4">{{ $blog->title }}</h2>
            <img src="{{ asset($blog->image)}}" class="w-full mb-4" alt="Blog Image">
            <p>{{ $blog->content }}</p>
            Written by {{ $blog->username }}
            <p style="font-size: 0.8rem; color:rgba(34, 34, 35, 0.493);">{{ $blog->created_at }}</p>

            <h5 class="text-lg font-semibold mt-8 mb-4">Comments</h5>
            <div class="col">
                @foreach ($comments as $comment)
                    <div class="col-auto mb-4">

                        <!-- Comment Content -->
                        <div class="ml-2">
                            {{ $comment->comment }}
                            @if ($userId === $comment->user_id && $hasAuthToken)
                                <!-- Trash Icon -->
                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}"
                                    onclick="event.preventDefault(); document.getElementById('delete-comment-{{ $comment->id }}').submit();">
                                    <i class="bi bi-trash" style="font-size: 0.9rem; color: rgba(157, 4, 4, 0.879);"></i>
                                </a>
                                {{-- Delete Form --}}
                                <form id="delete-comment-{{ $comment->id }}"
                                    action="{{ route('comment.delete', ['id' => $comment->id]) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                            <p style="font-size: 0.9rem; color:rgba(34, 34, 35, 0.493);">{{ $comment->username }} </p>
                        </div>
                    </div>
                @endforeach
            </div>



            <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                class="text-blue-900 text-lg mt-4">Type a comment</a>
        </div>
    </div>

    @include('components.comment')
@endsection
