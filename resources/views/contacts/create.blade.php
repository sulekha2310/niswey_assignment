@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ isset($contact) ? 'Edit Contact' : 'New Contact' }}</h1>
    <div>
        <a class="btn btn-secondary" href="{{ route('contacts.index') }}">Back</a>
    </div>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($contact) ? route('contacts.update', $contact) : route('contacts.store') }}" method="POST">
    @csrf
    @if(isset($contact)) @method('PUT') @endif

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $contact->name ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $contact->phone ?? '') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($contact) ? 'Update' : 'Save' }}</button>
</form>
@endsection
