@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">All Redirects (Total: {{ $redirectsCount }})</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Redirects table listing --}}
                    @if(count($redirects))
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Source</th>
                                    <th scope="col">Target</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($redirects as $key => $redirect)
                                <tr>
                                    <th scope="row">{{ $key }}</th>
                                    <td>{{ $redirect->path }}</td>
                                    <td>{{ $redirect->target }}</td>
                                    <td>
                                        <a href="{{ route('redirects.edit', $redirect->id) }}"><button type="button" class="btn btn-primary btn-sm">Update</button></a>
                                        <a href="{{ route('redirects.destroy', $redirect->id) }}"><button type="button" class="btn btn-danger btn-sm">Delete</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        No redirects added
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
