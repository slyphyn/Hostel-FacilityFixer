@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($news as $article)
                @php
                    $pastelColors = ['#FFC3A0', '#FFDEA2', '#A0E7E5', '#B1D4FF', '#FFD3B6'];
                    $colorIndex = $loop->index % count($pastelColors);
                @endphp

                <div class="col-md-6">
                    <a href="{{ route('admin.news.show', $article->id) }}" class="card-link">
                        <div class="card mb-4 news-card" style="background-color: {{ $pastelColors[$colorIndex] }}">
                            @if ($article->image)
                                <div class="news-image-container">
                                    <img src="{{ $article->image_url }}" class="card-img-top news-image" alt="News Image">
                                </div>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ $article->content }}</p>
                                <p class="card-text">Visibility: {{ getVisibilityLabel($article->visibility) }}</p>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('admin.news.show', $article->id) }}" class="btn btn-sm btn-primary mb-2">View Details</a>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .news-card {
            height: 400px; /* Set the fixed height as needed */
            display: flex;
            flex-direction: column;
        }

        .news-image-container {
            overflow: hidden;
            flex-shrink: 0; /* Prevent the image from shrinking */
            max-height: 200px; /* Adjust the max-height as needed */
        }

        .news-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-body {
            flex-grow: 1; /* Allow the card body to grow and take remaining space */
        }

        .card-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            max-height: 3.6em; /* Adjust the max height for the text */
            line-height: 1.8em; /* Adjust the line height for the text */
        }

        .card-footer {
            margin-top: auto; /* Push the footer to the bottom */
        }

        .news-card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }

        .card-link {
            text-decoration: none; /* Remove the default underline for anchor tags */
            color: inherit; /* Inherit the text color from the parent */
        }
    </style>

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
