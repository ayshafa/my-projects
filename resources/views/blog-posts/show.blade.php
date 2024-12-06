@extends('layout')

@section('content')
    <h1>{{ $blogPost->title }}</h1>
    <p><strong>Description:</strong> {{ $blogPost->description }}</p>
    <div>
        <strong>Content:</strong>
        {!! nl2br(e($blogPost->content)) !!}
    </div>
    @if($blogPost->image)
        <div class="mt-3">
        <img src="{{ asset('assets/images/blog/' . $blogPost->image) }}" alt="Blog Image" class="img-fluid">
        </div>
    @endif
    <p><strong>Status:</strong> {{ $blogPost->status ? 'Enabled' : 'Disabled' }}</p>

    <a href="{{ route('blog-posts.index') }}" class="btn btn-primary mt-3">Back to List</a>
@endsection
