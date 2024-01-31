@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit News') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title">{{ __('Title') }}:</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $news->title }}" required>
                            </div>

                            <div style="margin-bottom: 20px;"></div>


                            <div class="form-group">
                                <label for="content">{{ __('Content') }}:</label>
                                <textarea name="content" id="content" class="form-control" required>{{ $news->content }}</textarea>
                            </div>
                            
                            <div style="margin-bottom: 20px;"></div>


                            <div class="form-group">
                                <label for="visibility">{{ __('Visibility') }}:</label>
                                <select name="visibility" id="visibility" class="form-control">
                                    <option value="1" {{ $news->visibility == 1 ? 'selected' : '' }}>{{ __('Users') }}</option>
                                    <option value="2" {{ $news->visibility == 2 ? 'selected' : '' }}>{{ __('Staff') }}</option>
                                    <option value="3" {{ $news->visibility == 3 ? 'selected' : '' }}>{{ __('Both') }}</option>
                                </select>
                            </div>

                            <div style="margin-bottom: 20px;"></div>

                            <div class="form-group">
                                <label for="image">{{ __('Image') }}:</label>
                                <input type="file" name="image" id="image" class="form-control-file">
                            </div>

                            <div style="margin-bottom: 20px;"></div>


                            <button type="submit" class="btn btn-primary">{{ __('Update News') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
