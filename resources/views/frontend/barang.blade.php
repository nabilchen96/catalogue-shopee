@extends('frontend.app')
@push('meta-description')
    <meta name="description" content="Sungky Catalogue adalah website yang berisi produk-produk terlaris yang dijual oleh shopee">
@endpush
@push('style')
    <style>
        .act-btn {
            display: block;
            width: 50px;
            height: 50px;
            line-height: 50px;
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

        .col-sm-4:not(:first-child) {
            margin-left: 1rem;
            /* Sesuaikan nilai margin kiri sesuai kebutuhan */
        }

        .judul_berita {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            height: 35px;
        }
    </style>
@endpush
@section('hero')
        <div
            style="
    background: #4b49ac;
    background-image:  
    url('https://cdn.pixabay.com/photo/2022/08/05/07/06/background-7366180_1280.jpg'); 
    height: 200px; 
    background-position: center;
    background-size: cover;
    width: 100%;">

        </div>
@endsection
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 px-1">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Barang</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group mb-4 mt-3">
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
        @foreach ($barang as $k => $item)
            <div class="col-lg-2 col-6 px-1">
                <a style="text-decoration: none;" href="{{ $item->afiliasi_url }}">
                    <div class="card shadow mb-4">
                        <div
                            style="
                            border-top-left-radius: 8px;
                            border-top-right-radius: 8px;
                            width: 100%;
                            aspect-ratio: 1/1;
                            background-position: center;
                            background-size: cover;
                            @if ($item->foto_pertama) background-image: url('{{ asset('foto_pertama') }}/{{ $item->foto_pertama }}');
                            @else 
                                background-image: url('{{ asset('no_image.jpg') }}'); @endif
                            ">

                        </div>
                        <div class="card-body p-2">
                            <span style="font-size: 12px;" class="judul_berita mt-0 mb-2">{{ $item->nama_barang }}</span>
                            <span style="font-size: 16px;" class="text-danger">Rp.
                                {{ number_format($item->harga_start) }}</span>
                            <div class="d-flex justify-content-between mt-2 mb-2">
                                <div style="font-size: 12px;">{{ $item->rating }} <i class="text-danger bi bi-star"></i>
                                </div>
                                <div style="font-size: 12px;">{{ $item->terjual }} Terjual</div>
                            </div>
                            <a href="{{ url('detail-barang') }}/{{ $item->slug }}" style="font-size: 12px;"><i class="bi bi-bag"></i> Detail</a>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-12 px-1">
            {{ $barang->links() }}
        </div>
    </div>
@endsection
