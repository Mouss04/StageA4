@extends('base')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('interface.communications') }}</h1>

    @can('create Communication')
        <a href="{{ route('communications.create') }}" class="btn btn-primary mb-3">{{ __('interface.add_communication') }}</a>
    @endcan

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @can('read Communication')
        @if(auth()->check() && auth()->user()->hasRole('admin'))
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('interface.title') }}</th>
                        <th>{{ __('interface.date') }}</th>
                        <th>{{ __('interface.time') }}</th>
                        <th>{{ __('interface.type') }}</th>
                        <th>{{ __('interface.program_session') }}</th>
                        <th>{{ __('interface.room') }}</th>
                        <th>{{ __('interface.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($communications as $communication)
                        <tr>
                            <td>{{ $communication->title }}</td>
                            <td>{{ $communication->date }}</td>
                            <td>{{ $communication->start_time }} - {{ $communication->end_time }}</td>
                            <td>{{ ucfirst($communication->type) }}</td>
                            <td>{{ $communication->programSession?->name ?? __('interface.na') }}</td>
                            <td>{{ $communication->room?->name ?? __('interface.na') }}</td>
                            <td>
                            @if(auth()->check() && auth()->user()->can('create Favorite'))
                                <x-favorite-button modelType="App\Models\Communication" :modelId="$communication->id" />
                            @endif
                                <a href="{{ route('communications.show', $communication) }}" class="btn btn-info btn-sm">{{ __('interface.view') }}</a>

                                @can('update Communication')
                                    <a href="{{ route('communications.edit', $communication) }}" class="btn btn-warning btn-sm">{{ __('interface.edit') }}</a>
                                @endcan

                                @can('delete Communication')
                                    <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('interface.confirm_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('interface.delete') }}</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">{{ __('interface.no_communications') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="row">
                @forelse ($communications as $communication)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $communication->title }}</h5>
                                <p class="card-text"><strong>{{ __('interface.date') }}:</strong> {{ $communication->date }}</p>
                                <p class="card-text"><strong>{{ __('interface.time') }}:</strong> {{ $communication->start_time }} - {{ $communication->end_time }}</p>
                                <p class="card-text"><strong>{{ __('interface.type') }}:</strong> {{ ucfirst($communication->type) }}</p>
                                <p class="card-text"><strong>{{ __('interface.room') }}:</strong> {{ $communication->room?->name ?? __('interface.na') }}</p>
                                <a href="{{ route('communications.show', $communication) }}" class="btn btn-info btn-sm">{{ __('interface.view') }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">{{ __('interface.no_communications') }}</p>
                @endforelse
            </div>
        @endif
    @endcan

    <div class="d-flex justify-content-center">
        {{ $communications->links() }}
    </div>
</div>
@endsection
