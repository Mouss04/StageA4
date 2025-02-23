@extends('base')

@section('title', __('interface.add_sponsor'))

@section('content')

<div class="container mt-5">
    <h1>{{ __('interface.add_sponsor') }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('sponsors.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('interface.sponsor_name') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
    <label for="category" class="form-label">{{ __('interface.category') }}</label>
    <select id="category" name="category" class="form-control">
        <option value="">{{ __('interface.select_category') }}</option>
        <option value="medical_devices" {{ old('category') == 'medical_devices' ? 'selected' : '' }}>
            {{ __('interface.medical_devices') }}
        </option>
        <option value="pharmaceutical_distributors" {{ old('category') == 'pharmaceutical_distributors' ? 'selected' : '' }}>
            {{ __('interface.pharmaceutical_distributors') }}
        </option>
        <option value="parapharmacy_phytotherapy" {{ old('category') == 'parapharmacy_phytotherapy' ? 'selected' : '' }}>
            {{ __('interface.parapharmacy_phytotherapy') }}
        </option>
        <option value="hospital_pharmacy" {{ old('category') == 'hospital_pharmacy' ? 'selected' : '' }}>
            {{ __('interface.hospital_pharmacy') }}
        </option>
        <option value="publishing" {{ old('category') == 'publishing' ? 'selected' : '' }}>
            {{ __('interface.publishing') }}
        </option>
        <option value="pharmaceutical_laboratories" {{ old('category') == 'pharmaceutical_laboratories' ? 'selected' : '' }}>
            {{ __('interface.pharmaceutical_laboratories') }}
        </option>
        <option value="childcare_infant_milk" {{ old('category') == 'childcare_infant_milk' ? 'selected' : '' }}>
            {{ __('interface.childcare_infant_milk') }}
        </option>
        <option value="services" {{ old('category') == 'services' ? 'selected' : '' }}>
            {{ __('interface.services') }}
        </option>
        <option value="pharmaceutical_industry_suppliers" {{ old('category') == 'pharmaceutical_industry_suppliers' ? 'selected' : '' }}>
            {{ __('interface.pharmaceutical_industry_suppliers') }}
        </option>
        <option value="institutions_partners" {{ old('category') == 'institutions_partners' ? 'selected' : '' }}>
            {{ __('interface.institutions_partners') }}
        </option>
    </select>
</div>



        <div class="mb-3">
            <label for="description" class="form-label">{{ __('interface.description') }}</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">{{ __('interface.logo') }}</label>
            <input type="file" id="logo" name="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('interface.add') }}</button>
        <a href="{{ route('sponsors.index') }}" class="btn btn-secondary">{{ __('interface.cancel') }}</a>
    </form>
</div>

@endsection
