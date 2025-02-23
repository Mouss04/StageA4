@extends('base')

@section('title', __('interface.my_favorites'))

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">{{ __('interface.my_favorites') }}</h2>

    @if(auth()->user()->cannot('read Favorite'))
    <div class="alert alert-danger">{{ __('interface.no_permission') }}</div>
    @php abort(403) @endphp
    @endif

    @if($favorites->isEmpty())
    <p>{{ __('interface.no_favorites_found') }}</p>
    @else
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="favoriteTabs" role="tablist">
        @foreach($favorites as $modelType => $items)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ Str::slug($modelType) }}"
                data-bs-toggle="tab" data-bs-target="#content-{{ Str::slug($modelType) }}"
                type="button" role="tab" aria-controls="content-{{ Str::slug($modelType) }}"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                {{ __('interface.'.class_basename($modelType)) }}
            </button>
        </li>
        @endforeach
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-3" id="favoriteTabsContent">
        @foreach($favorites as $modelType => $items)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
            id="content-{{ Str::slug($modelType) }}"
            role="tabpanel" aria-labelledby="tab-{{ Str::slug($modelType) }}">

            @if(auth()->check() && auth()->user()->hasRole('admin'))
            <!-- Admin: Table View -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('interface.type') }}</th>
                        <th>{{ __('interface.title') }}</th>
                        <th>{{ __('interface.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $favorite)
                    @php
                    $model = app($favorite->model_type)::find($favorite->model_id);
                    @endphp
                    @if($model)
                    <tr>
                        <td>{{ class_basename($modelType) }}</td>
                        <td>
                            {{ method_exists($model, 'getTitle') ? $model->getTitle() : class_basename($modelType) . " #" . $model->id }}
                        </td>
                        <td>
                            <form action="{{ route('favorites.toggle', ['modelType' => $favorite->model_type, 'modelId' => $favorite->model_id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('interface.remove') }}</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            @else
            <!-- Moderators & Visitors: Card View -->
            <div class="row">
                @foreach($items as $favorite)
                @php
                $model = app($favorite->model_type)::find($favorite->model_id);
                @endphp
                @if($model)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ method_exists($model, 'getTitle') ? $model->getTitle() : class_basename($modelType) . " #" . $model->id }}
                            </h5>

                            @if($model instanceof App\Models\Communication)
                            <p>{{ $model->description }}</p>
                            <p><strong>{{ __('interface.date') }}:</strong> {{ $model->date }}</p>
                            <p><strong>{{ __('interface.time') }}:</strong> {{ $model->start_time }} - {{ $model->end_time }}</p>

                            @elseif($model instanceof App\Models\ProgramSession)
                            <p>{{ $model->name }}</p>
                            <p><strong>{{ __('interface.date') }}:</strong> {{ $model->date }}</p>

                            @elseif($model instanceof App\Models\Question)
                            <p>{{ $model->content }}</p>
                            <p><strong>{{ __('interface.answer') }}:</strong> {{ $model->answer ?? __('interface.not_answered') }}</p>

                            @elseif($model instanceof App\Models\Speaker)
                            <p><strong>{{ __('interface.name') }}:</strong> {{ $model->full_name }}</p>
                            <p>{{ $model->biography }}</p>

                            @elseif($model instanceof App\Models\Sponsor)
                            <p><strong>{{ __('interface.name') }}:</strong> {{ $model->name }}</p>
                            <p>{{ $model->description }}</p>

                            @endif

                            <!-- Favorite Toggle Button -->
                            <form action="{{ route('favorites.toggle', ['modelType' => $favorite->model_type, 'modelId' => $favorite->model_id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('interface.remove') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
