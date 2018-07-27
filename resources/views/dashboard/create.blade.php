@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add new redirect</div>

                <div class="card-body">
                    @if(session('status'))
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

                    <form method="POST" action="{{ route('redirects.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>Source</label>
                            <input type="text" class="form-control" name="path" placeholder="enter path...">
                        </div>

                        <label>Target</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="redirect_type" id="custom_url" value="custom_url">
                            <label class="form-check-label" for="custom_url">Custom URL</label>
                        </div>

                        @if(count($products))
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="redirect_type" id="product" value="product_url">
                            <label class="form-check-label" for="product">Product</label>
                        </div>
                        @endif

                        <div id="custom_url_selector" class="mt-2">
                            <input type="text" class="form-control" name="custom_url" placeholder="enter path...">
                        </div>

                        @if(count($products))
                        <div id="product_url_selector" class="mt-2">
                            <select class="form-control" name="product_url">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ '/product/' . $product->handle }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <br>

                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.scripts')
@endsection
