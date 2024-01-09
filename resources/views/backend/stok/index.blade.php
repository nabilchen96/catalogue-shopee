@extends('backend.app')
@push('style')
    <style>
        .act-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            text-align: center;
            color: white;
            font-size: 30px;
            font-weight: bold;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            text-decoration: none;
            transition: ease all 0.3s;
            position: fixed;
            right: 30px;
            bottom: 30px;
            text-decoration: none !important;
            z-index: 9;
        }

        .act-btn:hover {
            background: white;
        }

        th,
        td {
            white-space: nowrap !important;
        }
    </style>
@endpush
@section('content')
    <a onclick="showLoadingIndicator()" href="{{ url('export-pdf-stok') }}" class="bg-danger act-btn"><i style="font-size: 20px;" class="bi bi-file-earmark-pdf"></i></a>
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 px-1">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Laporan Stok</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group mb-3 mt-3">
                    <input type="text" value="{{ Request('q') }}" style="border: none;" class="form-control"
                        name="q" placeholder="Type to Search or Clear to See All Data ...">
                    <button onclick="showLoadingIndicator()" type="submit" style="border: none; height: 38px;"
                        class="input-group-text bg-primary text-white" id="basic-addon2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 px-1">
            <div class="mb-3">
                <div class="">
                    <div class="table-responsive">
                        <table class="table bg-white table-striped" style="width: 100%;">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Gambar</th>
                                    <th>Barang</th>
                                    <th>Stok</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $k => $item)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>
                                            <div
                                                style="
                                            width: 50px;
                                            height: 50px;
                                            background-size: cover;
                                            background-position: center;
                                            @if ($item->foto_barang) 
                                                background-image: url('{{ asset('foto_barang') }}/{{ $item->foto_barang }}');
                                            @else 
                                                background-image: url('{{ asset('no_image.jpg') }}'); 
                                            @endif    
                                            ">
                                            </div>
                                        </td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script></script>
@endpush
