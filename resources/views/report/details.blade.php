@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Report</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Details</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <section class="report-title">
        <h1>{{ $report->title }}</h1>
    </section>

    <div class="top">
        <div class="status-section profile">
            <div class="info">
                @if ($report->status === 'pending')
                    <button class="status-button {{ getStatus($report->status) }}" data-toggle="modal"
                        data-target="#updateModal{{ $report->id }}">
                        {{ $report->status }}
                    </button>

                    <!-- Status update modal -->
                    <div class="modal fade" id="updateModal{{ $report->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="updateModalLabel{{ $report->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('status.update', ['id' => $report->id]) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="status" value="">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel{{ $report->id }}">
                                            {{ $report->title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Do you want to update the status of this report?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary"
                                            onclick="setStatus(1)">Accept</button>
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#noteModal{{ $report->id }}">
                                            Reject
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Reject note modal -->
                    <div class="modal fade" id="noteModal{{ $report->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="noteModalLabel{{ $report->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="noteModalLabel{{ $report->id }}">
                                        Please write your note for rejecting this report
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('status.update', ['id' => $report->id]) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="status" value="0">
                                    <div class="modal-body">
                                        <input type="text" class="form-control" name="note"
                                            placeholder="Write a note..." required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <span class="status-button {{ getStatus($report->status) }}">{{ $report->status }}</span>
                @endif

                @if ($report->status === 'reject')
                    <div class="canceled-note mt-3">
                        <a data-toggle="collapse" href="#collapseExample" role="button" aria-controls="collapseExample"
                            aria-expanded="false" class="btn ripple btn-primary">Canceled note</a>
                        <div class="collapse mt-2" id="collapseExample">
                            <div>{{ $report->canceled_note }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="profile product-info">
            <h5><strong>Product</strong></h5>
            <div class="info">
                <div class="info-item"><strong>Title:</strong> {{ $report->product->title }}</div>
                <div class="info-item"><strong>Description:</strong> {{ $report->product->description }}</div>
                <div class="info-item"><strong>Status:</strong> {{ $report->product->status == 1 ? 'Active' : 'Inactive' }}
                </div>
                <div class="info-item"><strong>Terms:</strong> {{ $report->product->terms }}</div>
                <div class="info-item"><strong>URL:</strong> <a
                        href="{{ $report->product->url }}">{{ $report->product->url }}</a></div>

                <form action="{{ route('company.profile', ['uuid' => $report->product->company->uuid]) }}" method="get">
                    <button class="status-button bg-blue-500" type="submit">{{ $report->product->company->name }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="pdf-container">
        <iframe src="{{ asset('pdf/example.pdf') }}" allow="fullscreen"></iframe>
    </div>

    {{-- Styles --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            gap: 20px;
        }

        .profile {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .info {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .info-item {
            margin: 8px 0;
        }

        .status-button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .bg-blue-500 {
            background-color: blue;
            color: white;
        }

        .pdf-container {
            width: 100%;
            height: 100vh;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        iframe {
            width: 100%;
            max-width: 1000px;
            height: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: none;
        }
    </style>

    <script>
        function setStatus(value) {
            document.querySelector('input[name="status"]').value = value;
        }
    </script>
@endsection
@section('js')
@endsection
