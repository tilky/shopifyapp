@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Update a redirect</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('redirects.update') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $redirect->id }}">
                        <div class="form-group">
                            <label>Source</label>
                            <input type="text" class="form-control" name="path" value="{{ $redirect->path }}" placeholder="Redirecting from...">
                        </div>
                        <div class="form-group">
                            <label>Target</label>
                            <input type="text" class="form-control" name="target" value="{{ $redirect->target }}" placeholder="Redirecting to...">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection