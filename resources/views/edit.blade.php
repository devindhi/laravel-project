<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
@extends('layout')
@section('title', 'Home')
@section('content')
@include('components.alert')
<div class="container">
    <div class="row justify-content-center">
        <a href="{{ url('/') }}">
            <button type="button" class="btn btn-success m-4"><i class="bi bi-skip-backward-fill"></i></button>
        </a>
        <div class="col-md-8"> <!-- Adjust the width as needed -->
            <form action="{{ route('blog.update', ['id' => $blog->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h1>Edit Blog</h1>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="{{$blog->title}}">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Content</label>
                    <textarea type="text" class="form-control"  name="content">{{$blog->content}}></textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleInputImage" class="form-label">Choose Image</label>
                    <input type="file" class="form-control" name="image" value="{{$blog->image}}">
                </div>
                <div class="modal-footer">
                
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
