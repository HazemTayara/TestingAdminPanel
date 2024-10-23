@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- Header-Content -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Specialization</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Add Specialization</span>
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
            <h4 class="card-title mb-1">Add Specialization</h4>
        </div>
        <div class="card-body pt-0">
            <form class="form-horizontal" method="POST" action="{{ route('specialization.store') }}">
                @csrf
                <!-- Title -->
                <div class="form-group">
                    <input id="inputName" type="text" class="form-control" @error('title') is-invalid @enderror
                        name="title" value="{{ old('title') }}" required autocomplete="title" placeholder="Title">
                    @if ($errors->has('title'))
                        <div class="alert text-danger" role="alert">
                            <strong><i class="fas fa-exclamation-circle"></i> {{ $errors->first('title') }}</strong>
                        </div>
                    @endif


                </div>
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
