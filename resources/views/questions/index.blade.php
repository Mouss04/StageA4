@extends('base')

@section('title', __('interface.questions'))

@section('content')
<div class="container text-center mt-5">
    <!-- Title -->
    <div class="mb-4">
        <h1 class="text-white p-3" style="background-color: #56B947; border-radius: 10px;">{{ __('interface.questions') }}</h1>
    </div>

    @if(auth()->check() && auth()->user()->can('create Question'))
    <a href="{{ route('questions.create') }}" class="btn btn-success mb-3">{{ __('interface.ask_question') }}</a>
    @endif

    <!-- Question Statistics -->
    <div class="d-flex justify-content-center mb-4">
        @if(auth()->check() && auth()->user()->can('update Question'))
        <div class="p-3 me-2" style="background-color: #F2A341; border-radius: 10px;">
            <h5>{{ __('interface.pending') }}</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $pending_count }}</span>
        </div>
        @endif
        <div class="p-3 me-2" style="background-color: #56A6B4; border-radius: 10px;">
            <h5>{{ __('interface.validated') }}</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $validated_count }}</span>
        </div>
        <div class="p-3 me-2" style="background-color: #4CAF50; border-radius: 10px;">
            <h5>{{ __('interface.processed') }}</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $processed_count }}</span>
        </div>
        @if(auth()->check() && auth()->user()->can('update Question'))
        <div class="p-3 ms-2" style="background-color: #E74C3C; border-radius: 10px;">
            <h5>{{ __('interface.rejected') }}</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $rejected_count }}</span>
        </div>
        @endif
    </div>

    @if(auth()->check() && auth()->user()->can('update Question'))
    <!-- Section : Pending Questions -->
    <div class="p-4 mb-4" style="background-color: #F2A341; border-radius: 10px;">
        <h5 class="text-white">{{ __('interface.pending_questions') }} :</h5>
        @if($pending_questions->isEmpty())
        <p>{{ __('interface.no_pending_questions') }}</p>
        @else
        <div class="row">
            @foreach($pending_questions as $question)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <!-- Question Content -->
                        <div id="view-question-{{ $question->id }}">
                            <strong>{{ $question->content }}</strong>
                            <br>
                            <small>{{ __('interface.communication') }}: {{ $question->communication->title ?? __('interface.not_specified') }}</small>
                            @if ($question->speaker)
                            <br><small>{{ __('interface.speaker') }}: {{ $question->speaker->name }}</small>
                            @endif
                            @if(auth()->check() && auth()->user()->can('create Favorite'))
                            <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                            @endif

                            <div class="mt-2">
                                <form action="{{ route('questions.validate', $question->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">{{ __('interface.validate') }}</button>
                                </form>
                                <form action="{{ route('questions.reject', $question->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">{{ __('interface.reject') }}</button>
                                </form>
                                <button class="btn btn-warning btn-sm" onclick="showEditForm({{ $question->id }})">{{ __('interface.edit') }}</button>
                            </div>
                        </div>

                        <!-- Edit Form (Hidden by Default) -->
                        <div id="edit-question-{{ $question->id }}" style="display: none;">
                            <form action="{{ route('questions.update', $question->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <textarea name="content" class="form-control mb-2">{{ $question->content }}</textarea>
                                <button type="submit" class="btn btn-primary btn-sm">{{ __('interface.save') }}</button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="hideEditForm({{ $question->id }})">{{ __('interface.cancel') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    @endif

    <!-- Section : Validated Questions -->
    <div class="p-4 mb-4" style="background-color: #56A6B4; border-radius: 10px;">
        <h5 class="text-white">{{ __('interface.validated_questions') }} :</h5>
        @if($validated_questions->isEmpty())
        <p>{{ __('interface.no_validated_questions') }}</p>
        @else
        <div class="row">
            @foreach($validated_questions as $question)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <strong>{{ $question->content }}</strong>
                        <br>
                        <small>{{ __('interface.communication') }}: {{ $question->communication->title ?? __('interface.not_specified') }}</small>
                        @if ($question->speaker)
                        <br><small>{{ __('interface.speaker') }}: {{ $question->speaker->name }}</small>
                        @endif
                        @if(auth()->check() && auth()->user()->can('create Favorite'))
                        <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                        @endif

                        @if(auth()->check() && auth()->user()->can('update Question'))
                        <div class="mt-2">
                            <form action="{{ route('questions.process', $question->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">{{ __('interface.mark_as_processed') }}</button>
                            </form>
                            <form action="{{ route('questions.respond', $question->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="text" name="answer" class="form-control d-inline w-75" placeholder="{{ __('interface.answer') }}">
                                <button type="submit" class="btn btn-warning btn-sm">{{ __('interface.respond') }}</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Section : Processed Questions -->
    <div class="p-4 mb-4" style="background-color: #4CAF50; border-radius: 10px;">
        <h5 class="text-white">{{ __('interface.processed_questions') }} :</h5>
        @if($processed_questions->isEmpty())
        <p>{{ __('interface.no_processed_questions') }}</p>
        @else
        <div class="row">
            @foreach($processed_questions as $question)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <strong>{{ $question->content }}</strong>
                        <br>
                        <small>{{ __('interface.communication') }}: {{ $question->communication->title ?? __('interface.not_specified') }}</small>
                        @if ($question->speaker)
                        <br><small>{{ __('interface.speaker') }}: {{ $question->speaker->name }}</small>
                        @endif
                        <strong>{{ __('interface.answer') }}:</strong>
                        <p>{{ $question->answer ?? __('interface.no_answer') }}</p>
                        @if(auth()->check() && auth()->user()->can('create Favorite'))
                        <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Section : Rejected Questions -->
    @if(auth()->check() && auth()->user()->can('update Question'))
    <div class="p-4 mb-4" style="background-color: #E74C3C; border-radius: 10px;">
        <h5 class="text-white">{{ __('interface.rejected_questions') }} :</h5>
        @if($rejected_questions->isEmpty())
        <p>{{ __('interface.no_rejected_questions') }}</p>
        @else
        <div class="row">
            @foreach($rejected_questions as $question)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <!-- Question Content -->
                        <div id="view-question-{{ $question->id }}">
                            <strong>{{ $question->content }}</strong>
                            <br>
                            <small>{{ __('interface.communication') }}: {{ $question->communication->title ?? __('interface.not_specified') }}</small>
                            @if ($question->speaker)
                            <br><small>{{ __('interface.speaker') }}: {{ $question->speaker->name }}</small>
                            @endif
                            @if(auth()->check() && auth()->user()->can('create Favorite'))
                            <x-favorite-button modelType="App\Models\Question" :modelId="$question->id" />
                            @endif

                            <div class="mt-2">
                                <form action="{{ route('questions.validate', $question->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">{{ __('interface.validate') }}</button>
                                </form>
                                <form action="{{ route('questions.reject', $question->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">{{ __('interface.reject') }}</button>
                                </form>
                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm" onclick="showEditForm({{ $question->id }})">{{ __('interface.edit') }}</button>
                            </div>
                        </div>

                        <!-- Edit Form (Hidden by Default) -->
                        <div id="edit-question-{{ $question->id }}" style="display: none;">
                            <form action="{{ route('questions.update', $question->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <textarea name="content" class="form-control mb-2">{{ $question->content }}</textarea>
                                <button type="submit" class="btn btn-primary btn-sm">{{ __('interface.save') }}</button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="hideEditForm({{ $question->id }})">{{ __('interface.cancel') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endif


</div>
@endsection
