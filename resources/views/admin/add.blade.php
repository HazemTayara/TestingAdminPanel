@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- Header-Content -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Admin</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Add Admin</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
@endsection

@section('content')
    <!-- Body-Content -->
    <div class="card  box-shadow-0">
        <div class="card-header">
            <h4 class="card-title mb-1">Add Admin</h4>
        </div>
        <div class="card-body pt-0">
            <form class="form-horizontal" method="POST" action="{{ route('admin.store') }}">
                @csrf
                <!-- Name -->
                <div class="form-group">
                    <input id="inputName" type="text" class="form-control" @error('name') is-invalid @enderror
                        name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Name">
                    @if ($errors->has('name'))
                        <div class="alert text-danger" role="alert">
                            <strong><i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>
                <!-- Email -->
                <div class="form-group">
                    <input id="inputEmail3" type="email" class="form-control" @error('email') is-invalid @enderror
                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                    @if ($errors->has('email'))
                        <div class="alert text-danger" role="alert">
                            <strong><i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                </div>
                <!-- Phone -->
                <div class="form-group">
                    <input id="inputPhone" type="text" class="form-control" @error('phone') is-invalid @enderror
                        name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Phone">
                </div>
                @if ($errors->has('phone'))
                    <div class="alert text-danger" role="alert">
                        <strong><i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first('phone') }}</strong>
                    </div>
                @endif
                <!-- Password -->
                <div class="form-group">
                    <input id="inputPassword3" type="password" class="form-control" @error('password') is-invalid @enderror
                        name="password" value="{{ old('password') }}" required autocomplete="password"
                        placeholder="Password">
                </div>
                @if ($errors->has('password'))
                    <div class="alert text-danger" role="alert">
                        <strong><i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first('password') }}</strong>
                    </div>
                @endif
                <!-- Add Button -->
                <div class="form-group mb-0 mt-3 justify-content-end">
                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
