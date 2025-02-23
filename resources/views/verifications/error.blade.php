@extends('base')

@section('title', __('interface.edit_user'))

@section('content')
<h1>{{ __('interface.error') }} ❌</h1>
<p>{{ $message }}</p>

<a href="{{ route('users.index') }}" style="display: inline-block; padding: 10px 15px; background: red; color: white; text-decoration: none; border-radius: 5px;">
    {{ __('interface.return_to_user_list') }}
</a>
@endsection
