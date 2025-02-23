@extends('base')

@section('title', __('interface.my_profile'))

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">{{ __('interface.my_profile') }}</h2>

    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ $user->avatar ? $user->avatar->getUrl() : asset('images/default-avatar.png') }}"
                     class="rounded-circle"
                     width="150" height="150"
                     alt="{{ __('interface.avatar') }}">
            </div>

            <h4 class="text-center mt-3">{{ $user->full_name }}</h4>
            <p class="text-center">{{ $user->job_title ?? __('interface.no_job_title') }}</p>

            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>{{ __('interface.email') }}:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>{{ __('interface.institution') }}:</strong> {{ $user->institution ?? __('interface.not_provided') }}</li>
                <li class="list-group-item"><strong>{{ __('interface.address') }}:</strong> {{ $user->address ?? __('interface.not_provided') }}</li>
                <li class="list-group-item"><strong>{{ __('interface.country') }}:</strong> {{ $user->country ?? __('interface.not_provided') }}</li>
                <li class="list-group-item"><strong>{{ __('interface.state_region') }}:</strong> {{ $user->state ?? __('interface.not_provided') }}</li>
            </ul>

            <div class="text-center mt-3">
                <!-- QR Code -->
                <div>
                    <p><strong>{{ __('interface.user_qr_code') }}:</strong></p>
                    {!! \QrCode::size(150)->generate($user->id) !!}
                </div>

                <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">{{ __('interface.edit_profile') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
