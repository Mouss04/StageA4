@extends('base')

@section('title', __('interface.session_details'))

@section('content')
<div class="container mt-5">
    <h1>{{ __('interface.session_details') }}</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">{{ $programSession->name }}</h5>
            <p><strong>{{ __('interface.date') }}:</strong> {{ $programSession->date }}</p>
            <p><strong>{{ __('interface.start_time') }}:</strong> {{ $programSession->start_time }}</p>
            <p><strong>{{ __('interface.end_time') }}:</strong> {{ $programSession->end_time }}</p>
            @if(auth()->check() && auth()->user()->can('create Favorite'))
            <x-favorite-button modelType="App\Models\ProgramSession" :modelId="$programSession->id" />
            @endif

            <hr>

            <h5>{{ __('interface.related_communications') }}</h5>
            @if ($programSession->communications->isNotEmpty())
                <div class="row">
                    @foreach ($programSession->communications as $communication)
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('communications.show', $communication) }}">
                                            {{ $communication->title }}
                                        </a>
                                    </h5>
                                    <p><strong>{{ __('interface.description') }}:</strong> {{ $communication->description }}</p>
                                    <p><strong>{{ __('interface.date') }}:</strong> {{ $communication->date }}</p>
                                    <p><strong>{{ __('interface.time') }}:</strong> {{ $communication->start_time }} - {{ $communication->end_time }}</p>
                                    <p><strong>{{ __('interface.type') }}:</strong> {{ $communication->type }}</p>

                                    @if ($communication->room)
                                        <p><strong>{{ __('interface.room') }}:</strong> {{ $communication->room->name }}</p>
                                    @endif

                                    @if ($communication->speakers->isNotEmpty())
                                        <p><strong>{{ __('interface.speakers') }}:</strong>
                                            {{ $communication->speakers->pluck('name')->join(', ') }}
                                        </p>
                                    @endif

                                    @if ($communication->sponsors->isNotEmpty())
                                        <p><strong>{{ __('interface.sponsors') }}:</strong>
                                            {{ $communication->sponsors->pluck('name')->join(', ') }}
                                        </p>
                                    @endif

                                    <p><strong>{{ __('interface.associated_questions') }}:</strong> {{ $communication->questions->count() }}</p>

                                    <a href="{{ route('communications.show', $communication) }}" class="btn btn-info btn-sm">
                                        {{ __('interface.view_more') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>{{ __('interface.no_communications') }}</p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        @if(auth()->check() && auth()->user()->can('create Communication'))
            <a href="{{ route('communications.create', ['program_session_id' => $programSession->id]) }}" class="btn btn-success">
                <i class="fas fa-plus"></i> {{ __('interface.add_communication') }}
            </a>
        @endif

        @if(auth()->check() && auth()->user()->can('update ProgramSession'))
            <a href="{{ route('program_sessions.edit', $programSession) }}" class="btn btn-primary">{{ __('interface.edit') }}</a>
        @endif

        @if(auth()->check() && auth()->user()->can('delete ProgramSession'))
            <form action="{{ route('program_sessions.destroy', $programSession) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('interface.delete_session_confirmation') }}');">
                    {{ __('interface.delete') }}
                </button>
            </form>
        @endif

        @if(auth()->check() && auth()->user()->can('create Question'))
            <a href="{{ route('questions.create', ['session_id' => $programSession->id]) }}" class="btn btn-primary">
                {{ __('interface.ask_question') }}
            </a>
        @endif

        <a href="{{ route('program_sessions.index') }}" class="btn btn-secondary">{{ __('interface.back') }}</a>
    </div>
</div>
@endsection
