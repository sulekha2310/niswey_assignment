@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Import Contacts from XML</h1>
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

<p>Download a sample XML file: <a href="{{ asset('contacts.xml') }}" download>Sample XML</a></p>

<form action="{{ route('contacts.importXml') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Select XML File</label>
        <input type="file" name="xml_file" class="form-control" accept=".xml" required>
    </div>
    <button type="submit" class="btn btn-primary">Import</button>
</form>
@endsection
