@extends('frontend.app')
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

        .card-image-small {
            background-size: cover;
            background-position: center;
            aspect-ratio: 1 / 1;
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

        .image-preview {
            position: sticky;
            top: 90px;
        }

        .card-image {
            background-size: cover;
            background-position: center;
            height: 300px;
        }
    </style>
@endpush
@section('content')
    <a href="{{ $barang->afiliasi_url }}" class="bg-warning act-btn">
        <i class="bi bi-cart4"></i>
    </a>
    <div class="row">
        <div class="container d-flex justify-content-between mb-5">
            <div class="row">
                <div class="col-lg-4 px-4">
                    <div class="image-preview">
                        <a href="" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            data-bs-whatever="{{ asset('foto_pertama') }}/{{ @$barang->foto_pertama }}">
                            @if (@$barang->foto_pertama)
                                <div style="background-image: url('{{ asset('foto_pertama') }}/{{ @$barang->foto_pertama }}');"
                                    class="card card-image shadow">
                                </div>
                            @else
                                <div style="background-image: url('{{ asset('no_image.jpg') }}');"
                                    class="card card-image shadow">
                                </div>
                            @endif
                        </a>
                        <div class="row mt-3 mb-4">
                            @if (@$barang->foto_kedua)
                                <div class="col-2 mb-3" style="padding: 0 0 0 10px">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        data-bs-whatever="{{ asset('foto_kedua') }}/{{ @$barang->foto_kedua }}">
                                        <div style="background-image: url('{{ asset('foto_kedua') }}/{{ @$barang->foto_kedua }}');"
                                            class="shadow card card-image-small">
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if (@$barang->foto_ketiga)
                                <div class="col-2 mb-3" style="padding: 0 0 0 10px">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        data-bs-whatever="{{ asset('foto_ketiga') }}/{{ @$barang->foto_ketiga }}">
                                        <div style="background-image: url('{{ asset('foto_ketiga') }}/{{ @$barang->foto_ketiga }}');"
                                            class="shadow card card-image-small">
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if (@$barang->foto_keempat)
                                <div class="col-2 mb-3" style="padding: 0 0 0 10px">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        data-bs-whatever="{{ asset('foto_keempat') }}/{{ @$barang->foto_keempat }}">
                                        <div style="background-image: url('{{ asset('foto_keempat') }}/{{ @$barang->foto_keempat }}');"
                                            class="shadow card card-image-small">
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if (@$barang->foto_kelima)
                                <div class="col-2 mb-3" style="padding: 0 0 0 10px">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        data-bs-whatever="{{ asset('foto_kelima') }}/{{ @$barang->foto_kelima }}">
                                        <div style="background-image: url('{{ asset('foto_kelima') }}/{{ @$barang->foto_kelima }}');"
                                            class="shadow card card-image-small">
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if (@$barang->foto_pertama)
                                <div class="col-2 mb-3" style="padding: 0 0 0 10px">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        data-bs-whatever="{{ asset('foto_pertama') }}/{{ @$barang->foto_pertama }}">
                                        <div style="background-image: url('{{ asset('foto_pertama') }}/{{ @$barang->foto_pertama }}');"
                                            class="shadow card card-image-small">
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 px-4">
                    <div class="" style="min-height: 500px">
                        <div class="card-body p-0 ">
                            <div>
                                <h4>{{ $barang->nama_barang }}</h4>
                                <span class="badge bg-primary mb-2 text-white">
                                    <i class="bi bi-box-seam text-white"></i> {{ @$barang->kategori }}
                                </span>
                                <p>
                                    <span class="mr-4">Rating: {{ @$barang->rating }} <i class="bi bi-star"></i></span>
                                    <span>{{ @$barang->terjual }} Terjual</span>
                                </p>
                                <br>
                                <p style="font-size: 20px;">
                                    Rp. {{ number_format(@$barang->harga_start) }}
                                    @if (@$barang->harga_end)
                                        - Rp. {{ number_format(@$barang->harga_end) }}
                                    @endif
                                </p>
                                <a href="{{ $barang->afiliasi_url }}" class="badge bg-warning text-white"><i
                                        class="bi bi-cart4"></i> Segera beli!</a>



                                <hr>
                                <b>Deskripsi</b>
                                <p>
                                    <?php echo nl2br(@$barang->deskripsi); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <?php
                    $data = DB::table('barangs')->where('status', 'Aktif')->inRandomOrder()->limit(18)->get();
                ?>
                @foreach ($data as $k => $item)
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
                                    <span style="font-size: 12px;"
                                        class="judul_berita mt-0 mb-2">{{ $item->nama_barang }}</span>
                                    <span style="font-size: 16px;" class="text-danger">Rp.
                                        {{ number_format($item->harga_start) }}</span>
                                    <div class="d-flex justify-content-between mt-2 mb-2">
                                        <div style="font-size: 12px;">{{ $item->rating }} <i
                                                class="text-danger bi bi-star"></i>
                                        </div>
                                        <div style="font-size: 12px;">{{ $item->terjual }} Terjual</div>
                                    </div>
                                    <a href="{{ url('detail-barang') }}/{{ $item->slug }}" style="font-size: 12px;"><i
                                            class="bi bi-bag"></i> Detail</a>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endsection
    @push('script')
    @endpush
