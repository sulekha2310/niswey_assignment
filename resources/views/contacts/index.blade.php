@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="m-0">Niswey Assignment</h1>
    <div class="d-flex gap-2">
        <a class="btn btn-primary btn-sm" href="{{ route('contacts.create') }}">New</a>
        <a class="btn btn-secondary btn-sm" href="{{ route('contacts.import.form') }}">Import XML</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr><th>#</th><th>Name</th><th>Phone</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @forelse($all_list as $card)
            <tr>
                <td>{{ $card->id }}</td>
                <td>{{ $card->name }}</td>
                <td>{{ $card->phone }}</td>
                <td>
                    <a class="btn btn-sm btn-info" href="{{ route('contacts.edit', $card) }}">Edit</a>
                    <form action="{{ route('contacts.destroy', $card) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No record found</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($all_list->hasPages())
<nav>
    <ul class="pagination justify-content-end">
        @if($all_list->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $all_list->previousPageUrl() }}">&laquo;</a></li>
        @endif

        @foreach ($all_list->getUrlRange(1, $all_list->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $all_list->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        @if($all_list->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $all_list->nextPageUrl() }}">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</nav>
@endif


@endsection
