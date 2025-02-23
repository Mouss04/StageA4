@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('interface.create_speaker') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('speakers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="full_name" class="form-label">{{ __('interface.full_name') }}</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="biography" class="form-label">{{ __('interface.biography') }}</label>
                    <textarea class="form-control" id="biography" name="biography" rows="4" required>{{ old('biography') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label">{{ __('interface.avatar') }}</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('interface.create_speaker') }}</button>
                    <a href="{{ route('speakers.index') }}" class="btn btn-secondary">{{ __('interface.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
