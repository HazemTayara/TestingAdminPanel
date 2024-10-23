@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Researcher</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Show Researcher</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="flex-grow-1 mr-md-2">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search Researchers"
                            id="searchInput" aria-label="Search Companies">
                    </div>
                </div>
                <div class="mt-2 mt-md-0 ms-md-3"> <!-- Added margin-left for spacing -->
                    <button class="btn btn-outline-primary me-2" id="sortAscBtn">
                        <i class="bi bi-sort-alpha-up"></i> Ascending
                    </button>
                    <button class="btn btn-outline-primary" id="sortDescBtn">
                        <i class="bi bi-sort-alpha-down"></i> Descending
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row row-sm" id="companyList">
        @foreach ($researchers as $researcher)
            <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6 mb-4 company-item"
                data-name="{{ strtolower($researcher->name) }}">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-1">
                            <img src="{{ URL::asset('assets/img/brand/favicon.png') }}" alt="{{ $researcher->name }} Logo"
                                class="company-logo rounded-circle">
                            <div class="ml-1">
                                <h6 class="text-dark text-uppercase font-weight-bold mb-1">{{ $researcher->name }}</h6>
                            </div>
                        </div>
                        <p class="company-description text-muted">
                            {{ Str::limit(
                                ' Dolorem nemo explicabo at minus porro omnis. Maiores quia ea ipsam veniam porro. Qui fugit modi voluptatum.',
                                150,
                            ) }}
                        </p>
                        <span class="badge badge-light">{{ $researcher->points }} Points</span>
                        <form action="{{ route('researcher.profile', ['uuid' => $researcher->uuid]) }}" method="GET"
                            style="display: inline;">
                            <input type="hidden" name="uuid" value="{{ $researcher->uuid }}">
                            <button type="submit" class="btn btn-outline-primary mt-3"
                                style="width: 100%; border-radius: 10px;">
                                Learn More
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- /row -->

    <style>
        .company-logo {
            width: 60px;
            height: auto;
        }

        .company-description {
            max-height: 5em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 5;
            margin-top: 0.5em;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-primary {
            font-weight: bold;
        }

        .badge {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .company-logo {
                width: 50px;
            }
        }
    </style>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const companies = document.querySelectorAll('.company-item');

            companies.forEach(function(company) {
                const name = company.dataset.name;
                if (name.includes(filter)) {
                    company.style.display = '';
                } else {
                    company.style.display = 'none';
                }
            });
        });

        document.getElementById('sortAscBtn').addEventListener('click', function() {
            sortCompanies(true);
        });

        document.getElementById('sortDescBtn').addEventListener('click', function() {
            sortCompanies(false);
        });

        function sortCompanies(ascending) {
            const companyList = document.getElementById('companyList');
            const companies = Array.from(companyList.querySelectorAll('.company-item'));

            companies.sort((a, b) => {
                const nameA = a.querySelector('h6').textContent.toLowerCase();
                const nameB = b.querySelector('h6').textContent.toLowerCase();

                return ascending ? (nameA > nameB ? 1 : -1) : (nameA < nameB ? 1 : -1);
            });

            companies.forEach(company => companyList.appendChild(company));
        }
    </script>
@endsection

@section('js')
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!-- Internal Piety js -->
    <script src="{{ URL::asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>
    <!-- Internal Chart js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endsection
