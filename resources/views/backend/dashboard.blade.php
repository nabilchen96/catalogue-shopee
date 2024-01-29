@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
    <style>
        #myTable_filter input {
            height: 29.67px !important;
        }

        #myTable_length select {
            height: 29.67px !important;
        }

        .btn {
            border-radius: 50px !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #9e9e9e21 !important;
        }

        th,
        td {
            white-space: nowrap !important;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .biru {
            background-color: blue;
            color: white;
        }

        .hijau {
            background-color: green;
            color: white;
        }

        .kuning {
            background-color: yellow;
        }

        .oren {
            background-color: orange;
        }

        .merah {
            background-color: red;
            color: white;
        }

        .rotate-text {
            white-space: nowrap;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 grid-margin px-1">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Dashboard</h3>
                    <h6 class="font-weight-normal mb-0">Hi, {{ Auth::user()->name }}.
                        Welcome back to SIstem Informasi SPI</h6>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-3 mb-4">
                    <div class="card card-tale text-white shadow pt-2 mb-2">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Total Anggota</h4>
                            <h3 class="fs-30 mb-2">{{ @$anggota ?? 0 }}</h3>
                            <span>
                                <a href="{{ url('anggota') }}" class="text-white">
                                    List Anggota <i class="bi bi-arrow-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="card card-dark-blue text-white shadow pt-2 mb-2">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Upcoming Agenda</h4>
                            <h3 class="fs-30 mb-2">{{ @$agenda ?? 0 }}</h3>
                            <span>
                                <a href="{{ url('agenda') }}" class="text-white">
                                    List Agenda <i class="bi bi-arrow-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-4">
                    <div class="card card-light-blue text-white shadow pt-2 mb-2">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Penjualan Bulanan</h4>
                            <h4 class="fs-30 mb-2">Rp. {{ @@number_format($penjualan) ?? 0 }}</h4>
                            <span>
                                <a href="{{ url('penjualan') }}" class="text-white">
                                    List Penjualan <i class="bi bi-arrow-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="card card-light-danger text-white shadow pt-2 mb-2">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Sisa Cicilan</h4>
                            <h3 class="fs-30 mb-2">Rp. {{ number_format(@$cicilan) ?? 0 }}</h3>
                            <span>
                                <a href="{{ url('cicilan') }}" class="text-white">
                                    List Cicilan <i class="bi bi-arrow-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
