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
                <h4 class="content-title mb-0 my-auto">{{ $company->name . '\'s ' . 'Reports' }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> / Reports</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0"></h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">title</th>
                                    <th class="wd-15p border-bottom-0">status</th>
                                    <th class="wd-15p border-bottom-0">file</th>
                                    <th class="wd-20p border-bottom-0">product</th>
                                    <th class="wd-15p border-bottom-0">researcher</th>
                                    <th class="wd-10p border-bottom-0">review status</th>
                                    <th class="wd-10p border-bottom-0">created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($company->reports as $report)
                                        <td>{{ $report->title }}</td>
                                        <td>
                                            @if ($report->status === 'pending')
                                                <button class="status-button {{ getStatus($report->status) }}"
                                                    data-toggle="modal"
                                                    data-target="#updateModal{{ $report->id }}">{{ $report->status }}</button>

                                                <div class="modal fade" id="updateModal{{ $report->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="updateModalLabel{{ $report->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form
                                                                action="{{ route('status.update', ['id' => $report->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="updateModalLabel{{ $report->id }}">
                                                                        {{ $report->title }}</h5>

                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <h5>
                                                                            {{ 'Do you Want to update the status of this Report' }}
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="status-button {{ getStatus($report->status) }}">
                                                    {{ $report->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $report->file }}</td>
                                        <td>{{ $report->product->title }}</td>
                                        <td>{{ $report->researcher->name }}</td>
                                        <td>{{ $report->review_status }}</td>
                                        @php
                                            $date = \Carbon\Carbon::createFromDate($report->created_at);
                                        @endphp
                                        <td>{{ $date->format('F j, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container closed -->
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
