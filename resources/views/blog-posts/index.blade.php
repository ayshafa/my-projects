@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Blog Posts</h1>
        <a href="{{ route('blog-posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->status ? 'Enabled' : 'Disabled' }}</td>
                <td>
                    <a href="{{ route('blog-posts.show', $post->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('blog-posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('blog-posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No blog posts found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
