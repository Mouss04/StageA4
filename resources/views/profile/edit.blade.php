@extends('base')

@section('title', __('interface.edit_profile'))

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">{{ __('interface.edit_profile') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Avatar -->
        <div class="mb-3 text-center">
            <img src="{{ $user->avatar ? $user->avatar?->original_url : asset('images/default-avatar.png') }}"
                 class="rounded-circle" style="width: 120px; height: 120px;">
            <input type="file" name="avatar" class="form-control mt-2">
        </div>

        <!-- Nom complet -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.full_name') }}</label>
            <input type="text" name="full_name" class="form-control" value="{{ $user->full_name }}" required>
        </div>

        <!-- Surnom -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.nickname') }}</label>
            <input type="text" name="nickname" class="form-control" value="{{ $user->nickname }}">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.email') }}</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <!-- Métier -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.job_title') }}</label>
            <input type="text" name="job_title" class="form-control" value="{{ $user->job_title }}">
        </div>

        <!-- Institution -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.institution') }}</label>
            <input type="text" name="institution" class="form-control" value="{{ $user->institution }}">
        </div>

        <!-- Adresse -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.address') }}</label>
            <input type="text" name="address" class="form-control" value="{{ $user->address }}">
        </div>

        <!-- Pays -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.country') }}</label>
            <input type="text" name="country" class="form-control" value="{{ $user->country }}">
        </div>

        <!-- État -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.state') }}</label>
            <input type="text" name="state" class="form-control" value="{{ $user->state }}">
        </div>

        <!-- Mot de passe -->
        <div class="mb-3">
            <label class="form-label">{{ __('interface.new_password') }}</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('interface.confirm_password') }}</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('interface.update') }}</button>
    </form>
</div>
@endsection
