@extends('base')

@section('title', __('interface.edit_user'))

@section('content')

<div class="container mt-5">
    <h1>{{ __('interface.edit_user') }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="full_name" class="form-label">{{ __('interface.full_name') }}</label>
            <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="nickname" class="form-label">{{ __('interface.nickname') }}</label>
            <input type="text" name="nickname" id="nickname" class="form-control" value="{{ old('nickname', $user->nickname) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('interface.email') }}</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('interface.password') }} ({{ __('interface.leave_empty') }})</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('interface.password_confirmation') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label for="institution" class="form-label">{{ __('interface.institution') }}</label>
            <input type="text" name="institution" id="institution" class="form-control" value="{{ old('institution', $user->institution) }}">
        </div>
        <div class="mb-3">
            <label for="job_title" class="form-label">{{ __('interface.job_title') }}</label>
            <input type="text" name="job_title" id="job_title" class="form-control" value="{{ old('job_title', $user->job_title) }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">{{ __('interface.role') }}</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>{{ __('interface.admin') }}</option>
                <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>{{ __('interface.moderator') }}</option>
                <option value="visitor" {{ $user->role == 'visitor' ? 'selected' : '' }}>{{ __('interface.visitor') }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">{{ __('interface.address') }}</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
        </div>

        <div class="mb-3">
            <label for="state" class="form-label">{{ __('interface.state') }}</label>
            <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $user->state) }}">
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">{{ __('interface.country') }}</label>
            <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $user->country) }}">
        </div>

        <button type="submit" class="btn btn-success">{{ __('interface.update') }}</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('interface.cancel') }}</a>
    </form>
</div>

@endsection
