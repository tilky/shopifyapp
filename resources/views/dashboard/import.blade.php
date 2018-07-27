@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Import Redirects (csv)</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger pb-0">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form enctype="multipart/form-data" action="{{ route('redirects.processImport') }}" method="POST">
                        {{ csrf_field() }}
                        <small>
                            <p class="mb-0">Instructions: CSV file must have 2 columns with the following headings and include the redirects as appropriate line by line</p>
                            <ul>
                                <li>Path</li>
                                <li>Target</li>
                            </ul>
                            <a class="btn btn-sm btn-seconday" href="{{ url('csv/sample-csv.csv') }}">Download Sample CSV</a>
                        </small>

                        <div class="custom-file mt-3">
                            <input type="file" class="custom-file-input" name="redirects_csv" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection