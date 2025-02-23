@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('interface.speaker_details') }}</h1>

    <div class="card">
        <div class="card-header">
            <h3>{{ $speaker->full_name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>{{ __('interface.biography') }}:</strong></p>
            <p>{{ $speaker->biography }}</p>

            <p><strong>{{ __('interface.avatar') }}:</strong></p>
            @if($speaker->getFirstMediaUrl('avatar'))
                <img src="{{ $speaker->getFirstMediaUrl('avatar') }}" alt="Avatar" class="img-thumbnail" width="150">
            @else
                <p>{{ __('interface.no_avatar') }}</p>
            @endif

            <div class="mt-4">
            @if(auth()->check() && auth()->user()->can('create Favorite'))
                <x-favorite-button modelType="App\Models\Speaker" :modelId="$speaker->id" />
            @endif

                @if(auth()->check() && auth()->user()->can('update Speaker'))
                    <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-warning">{{ __('interface.edit') }}</a>
                @endif

                <a href="{{ route('speakers.index') }}" class="btn btn-secondary">{{ __('interface.back_to_list') }}</a>

                @if(auth()->check() && auth()->user()->can('delete Speaker'))
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSpeakerModal">
                        {{ __('interface.delete') }}
                    </button>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteSpeakerModal" tabindex="-1" aria-labelledby="deleteSpeakerLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteSpeakerLabel">{{ __('interface.confirm_delete') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ __('interface.delete_speaker_confirmation', ['speaker' => $speaker->full_name]) }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('interface.cancel') }}</button>
                                    <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">{{ __('interface.delete') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Questions related to this Speaker -->
    <div class="mt-5">
        <h4>{{ __('interface.questions_for', ['speaker' => $speaker->full_name]) }}</h4>

        @if($speaker->questions->isEmpty())
            <p>{{ __('interface.no_questions') }}</p>
        @else
            <div class="row">
                @foreach($speaker->questions as $question)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <strong>{{ $question->content }}</strong>
                                <br>
                                <small>{{ __('interface.communication') }}: {{ $question->communication->title ?? __('interface.not_specified') }}</small>
                                <div class="mt-3">
                                @if(auth()->check() && auth()->user()->can('create Favorite'))
                                    <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
