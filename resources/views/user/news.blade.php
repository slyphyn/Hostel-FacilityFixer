@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @forelse ($news->sortByDesc('created_at') as $key => $article)
                @php
                    $pastelColors = ['#FFC3A0', '#FFDEA2', '#A0E7E5', '#B1D4FF', '#FFD3B6'];
                    $colorIndex = $key % count($pastelColors);
                @endphp

                <div class="col-md-6">
                    <div class="card mb-4 news-card" style="background-color: {{ $pastelColors[$colorIndex] }}">
                        @if ($article->image)
                            <img src="{{ $article->image_url }}" class="card-img-top" alt="News Image">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->content, 150) }}</p>
                        </div>
                        <div class="card-footer text-muted">
                            Published on {{ $article->created_at->format('F j, Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p>No news articles available.</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .news-card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
    </style>
@endsection
