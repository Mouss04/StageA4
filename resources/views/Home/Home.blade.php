@extends('base')

@section('title', __('interface.home'))

@section('content')

<!-- Image stockée localement dans le dossier public -->
<div class="text-center">
    <a href="{{ asset('images/plan.jpg') }}" data-lightbox="image-1" data-title="{{ __('interface.event_plan') }}">
        <img src="{{ asset('images/plan.jpg') }}" alt="{{ __('interface.event_plan') }}" style="margin-top: 20px; width: 500px; height: 300px;">
    </a>
</div>

<!-- Contenu principal -->
<div class="container text-center" style="margin-top: 50px; padding-bottom: 80px;">
    <!-- Grille pour les boutons -->
    <div class="row justify-content-center">
        @php
            $buttons = [
                ['route' => 'program_sessions.index', 'icon' => 'fas fa-calendar-alt', 'text' => __('interface.event_program'), 'class' => 'btn-outline-primary'],
                ['route' => 'speakers.index', 'icon' => 'fas fa-microphone-alt', 'text' => __('interface.speakers'), 'class' => 'btn-outline-secondary'],
                ['route' => 'sponsors.index', 'icon' => 'fas fa-users', 'text' => __('interface.exhibitors'), 'class' => 'btn-outline-success'],
                ['route' => 'rooms.index', 'icon' => 'fas fa-building', 'text' => __('interface.rooms'), 'class' => 'btn-outline-danger'],
                ['route' => 'questions.index', 'icon' => 'fas fa-question-circle', 'text' => __('interface.questions'), 'class' => 'btn-warning'],
                ['route' => 'https://www.youtube.com/@siphaltv', 'icon' => 'fas fa-tv', 'text' => __('interface.siphal_tv'), 'class' => 'btn-dark', 'external' => true]
            ];
        @endphp

        @foreach ($buttons as $btn)
            <div class="col-sm-6 col-md-5 mb-4">
                <div class="card-body">
                    <a href="{{ isset($btn['external']) ? $btn['route'] : route($btn['route']) }}"
                       class="btn {{ $btn['class'] }} w-100"
                       @isset($btn['external']) target="_blank" @endisset>
                        <i class="{{ $btn['icon'] }}"></i> {{ $btn['text'] }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
