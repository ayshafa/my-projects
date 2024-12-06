@extends('layout')

@section('content')
    <h1>{{ isset($blogPost) ? 'Edit Blog Post' : 'Create Blog Post' }}</h1>
    <form action="{{ isset($blogPost) ? route('blog-posts.update', $blogPost->id) : route('blog-posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($blogPost))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $blogPost->title ?? '') }}">
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $blogPost->description ?? '') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{ old('content', $blogPost->content ?? '') }}</textarea>
            @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImage(event)">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if(isset($blogPost) && $blogPost->image)
                <img id="imagePreview" src="{{ asset('assets/images/blog/' . $blogPost->image) }}" alt="Image" class="img-fluid mt-3" style="max-width: 200px;">
            @else
                <img id="imagePreview" class="img-fluid mt-3" style="max-width: 200px; display: none;">
            @endif
        </div>


        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                <option value="1" {{ old('status', $blogPost->status ?? '') == 1 ? 'selected' : '' }}>Enabled</option>
                <option value="0" {{ old('status', $blogPost->status ?? '') == 0 ? 'selected' : '' }}>Disabled</option>
            </select>
            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ isset($blogPost) ? 'Update' : 'Create' }}</button>
    </form>
@endsection
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; 
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>