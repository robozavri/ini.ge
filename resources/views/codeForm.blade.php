@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">შესვლა</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('code_confirmation') }}">
                        @csrf

                        @if (\Session::has('msg'))
                      	    <p class="alert alert-default">
                      	      {!! \Session::get('msg') !!}
                      	    </p>
                      	@endif

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">კოდი</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="email" autofocus>

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        შესვლა
                                    </button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
