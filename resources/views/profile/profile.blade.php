@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Profile</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Profile</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" src="{{ URL::asset('assets/img/faces/6.jpg') }}"><a
                                    class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ Auth::user()->name }}</h5>
                                    <p class="main-profile-name-text">{{ Auth::user()->type }}</p>
                                </div>
                            </div>

                            <hr class="mg-y-30">
                            <label class="main-content-label tx-13 mg-b-20">Social</label>
                            <div class="main-profile-social-list">
                                <div class="media">
                                    <div class="media-icon bg-primary-transparent text-primary">
                                        <i class="icon ion-logo-github"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Github</span> <a href="">github.com/spruko</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-success-transparent text-success">
                                        <i class="icon ion-logo-twitter"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Twitter</span> <a href="">twitter.com/spruko.me</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-info-transparent text-info">
                                        <i class="icon ion-logo-linkedin"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Linkedin</span> <a href="">linkedin.com/in/spruko</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-danger-transparent text-danger">
                                        <i class="icon ion-md-link"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>My Portfolio</span> <a href="">spruko.com/</a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mg-y-30">
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row row-sm">
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-primary-transparent">
                                    <i class="icon-layers text-primary"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13">Orders</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">1,587</h2>
                                    <p class="text-muted mb-0 tx-11"><i
                                            class="si si-arrow-up-circle text-success mr-1"></i>increase</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-danger-transparent">
                                    <i class="icon-paypal text-danger"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13">Revenue</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">46,782</h2>
                                    <p class="text-muted mb-0 tx-11"><i
                                            class="si si-arrow-up-circle text-success mr-1"></i>increase</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-success-transparent">
                                    <i class="icon-rocket text-success"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13">Product sold</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">1,890</h2>
                                    <p class="text-muted mb-0 tx-11"><i
                                            class="si si-arrow-up-circle text-success mr-1"></i>increase</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">

                    </div>
                    <div class="tab-pane" id="settings">
                        <form method="POST" action="{{ route('profile.save') }}">
                            @csrf
                            <div class="form-group">
                                <label for="FullName">Full Name</label>
                                <input type="text" value={{ Auth::user()->name }} id="FullName" class="form-control"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" value="{{ Auth::user()->email }}" id="Email" class="form-control"
                                    readonly>
                            </div>
                            <!-- Old Password -->
                            <div class="form-group">
                                <label for="OldPassword">Old Password</label>
                                <input id="OldPassword" type="password" class="form-control" name="current_password"
                                    value="{{ old('current_password') }}" required>
                                @if ($errors->has('current_password'))
                                    <div class="alert text-danger" role="alert">
                                        <strong><i class="fas fa-exclamation-circle"></i>
                                            {{ $errors->first('current_password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- New Password -->
                            <div class="form-group">
                                <label for="NewPassword">New Password</label>
                                <input id="NewPassword" type="password" class="form-control" name="new_password"
                                    value="{{ old('new_password') }}" required>
                                @if ($errors->has('new_password'))
                                    <div class="alert text-danger" role="alert">
                                        <strong><i class="fas fa-exclamation-circle"></i>
                                            {{ $errors->first('new_password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- Conifermed Password -->
                            <div class="form-group">
                                <label for="ConPassword">Conifirm Password</label>
                                <input id="ConPassword" type="password" class="form-control"
                                    name="new_password_confirmation" value="{{ old('new_password_confirmation') }}"
                                    required>
                                @if ($errors->has('new_password_confirmation'))
                                    <div class="alert text-danger" role="alert">
                                        <strong><i class="fas fa-exclamation-circle"></i>
                                            {{ $errors->first('new_password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
