@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Researcher</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Profile
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="top">
        <div class="profile">
            <div class="d-flex align-items-center">
                <img src="{{ URL::asset('assets/img/brand/favicon.png') }}" alt="Company Logo" class="logo">
                <h1 class="company-name ms-3">{{ $researcher->name }}</h1>
            </div>

            <p class="description">
                {{ 'Dolorem nemo explicabo at minus porro omnis. Maiores quia ea ipsam veniam porro. Qui fugit modi voluptatum.' }}
            </p>

            <div class="info">
                <div class="info-item">
                    <strong><a href="{{ $researcher->facebook }}" target="_blank">{{ $researcher->facebook }}</a></strong>
                </div>
                <div class="info-item">
                    <strong><a href="{{ $researcher->linkedin }}" target="_blank">{{ $researcher->linkedin }}</a></strong>
                </div>
                <div class="info-item">
                    <strong><a href="{{ $researcher->github }}" target="_blank">{{ $researcher->github }}</a></strong>
                </div>
                <div class="info-item">
                    <strong>{{ 'Points: ' . $researcher->points }}</strong>
                </div>
                <div class="info-item">
                    <strong>{{ $researcher->email }}</strong>
                </div>
                <div class="info-item">
                    <strong>{{ $researcher->phone }}</strong>
                </div>
            </div>
        </div>
        <div class="photo">
            <img src="{{ URL::asset('assets/img/media/login.png') }}" alt="Researcher Photo" class="img-fluid">
        </div>
    </div>
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Reports</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">title</th>
                                    <th class="wd-15p border-bottom-0">product</th>
                                    <th class="wd-10p border-bottom-0">created at</th>
                                    <th class="wd-5p border-bottom-0"></th>
                                    <th class="wd-5p border-bottom-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($researcher->reports as $report)
                                    <tr>
                                        <td>{{ $report->title }}</td>
                                        <td>{{ $report->product->title }}</td>
                                        @php
                                            $date = \Carbon\Carbon::createFromDate($report->created_at);
                                        @endphp
                                        <td class="text-center">{{ $date->format('F j, Y') }}</td>
                                        <td class="text-center">
                                            <span class="status-button {{ getStatus($report->status) }}">
                                                {{ $report->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <form
                                                action="{{ route('report.details', ['uuid' => $report->uuid, 'id' => Auth::user()->id]) }}"
                                                method="post">
                                                @csrf
                                                <button class="status-button bg-blue-500"
                                                    type="submit">{{ 'Details' }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .status-button {
            display: inline-block;
            padding: 5px 10px;
            width: 100px;
            border: 1.8px solid;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        .bg-blue-500 {
            background-color: transparent;
            color: blue;
            border-color: blue;
        }

        .bg-gray-500 {
            background-color: transparent;
            color: gray;
            border-color: gray;
        }

        .bg-red-500 {
            background-color: transparent;
            color: red;
            border-color: red;
        }

        .bg-green-500 {
            background-color: transparent;
            color: green;
            border-color: green;
        }

        .bg-gold-500 {
            background-color: transparent;
            color: gold;
            border-color: gold;
        }

        .bg-default {
            background-color: lightgray;
            border-color: lightgray;
        }

        .top {
            display: flex;
            height: auto;
            margin-bottom: 30px;
        }

        .profile {
            margin-left: 20px;
            width: 50%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 8px;
            background-color: white;
        }

        .photo {
            background-color: #e9ecef;
            width: 50%;
            overflow: hidden;
            position: relative;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .logo {
            max-width: 100px;
            height: auto;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
        }

        .description {
            margin-top: 15px;
            font-size: 16px;
            color: #555;
        }

        .info {
            margin-top: 20px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .button-container {
            margin-top: 20px;
        }
    </style>
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
@endsection
