@extends('base')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ __('interface.rooms') }}</h1>
        @if(auth()->check() && auth()->user()->can('create Room'))
            <a href="{{ route('rooms.create') }}" class="btn btn-primary">{{ __('interface.create_room') }}</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->check() && auth()->user()->can('read Room'))
        @if(auth()->check() && auth()->user()->hasRole('admin'))
            <!-- ADMIN VIEW : TABLE -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('interface.room_name') }}</th>
                                <th>{{ __('interface.capacity') }}</th>
                                <th>{{ __('interface.description') }}</th>
                                <th>{{ __('interface.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $room->name }}</td>
                                    <td>{{ $room->capacity }}</td>
                                    <td>{{ $room->description }}</td>
                                    <td>
                                        @if(auth()->check() && auth()->user()->can('update Room'))
                                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-warning">{{ __('interface.edit') }}</a>
                                        @endif

                                        @if(auth()->check() && auth()->user()->can('delete Room'))
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoomModal{{ $room->id }}">
                                                {{ __('interface.delete') }}
                                            </button>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteRoomModal{{ $room->id }}" tabindex="-1" aria-labelledby="deleteRoomLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteRoomLabel">{{ __('interface.confirm_delete') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('interface.delete_confirmation', ['room' => $room->name]) }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('interface.cancel') }}</button>
                                                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ __('interface.delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- MODERATOR & VISITOR VIEW : CARDS -->
            <div class="row">
                @foreach($rooms as $room)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $room->name }}</h5>
                                <p><strong>{{ __('interface.capacity') }}:</strong> {{ $room->capacity }}</p>
                                <p>{{ $room->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
@endsection
