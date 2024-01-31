@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('News Details') }}</div>

                    <div class="card-body">
                        @if ($news->image)
                            <img src="{{ $news->image_url }}" class="img-fluid mb-3" alt="News Image">
                        @endif

                        <h2>{{ $news->title }}</h2>
                        <p>{{ $news->content }}</p>
                        <p>Visibility: {{ getVisibilityLabel($news->visibility) }}</p>

                        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-primary">Edit</a>

                        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this news article?')">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        function getVisibilityLabel($visibility) {
            switch ($visibility) {
                case 1:
                    return 'User';
                case 2:
                    return 'Staff';
                case 3:
                    return 'Both';
                default:
                    return 'Unknown';
            }
        }
    @endphp
@endsection
