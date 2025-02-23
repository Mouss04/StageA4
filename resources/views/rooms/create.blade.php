@extends('base')

@section('content')
<div class="container">
    <h1>{{ __('interface.create_new_room') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('interface.room_name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="capacity" class="form-label">{{ __('interface.capacity') }}</label>
                    <input type="number" name="capacity" class="form-control" id="capacity" value="{{ old('capacity') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('interface.description') }}</label>
                    <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('interface.create_room') }}</button>
                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">{{ __('interface.cancel') }}</a>
            </form>
        </div>
    </div>
</div>
@endsection
