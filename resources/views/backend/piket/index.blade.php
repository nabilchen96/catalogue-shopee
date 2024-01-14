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
    {{-- <a href="{{ url('export-pdf-absensi') }}" class="bg-danger act-btn"><i style="font-size: 20px;"
            class="bi bi-file-earmark-pdf"></i></a> --}}
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 px-1">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Piket IAD</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group mb-3 mt-3">
                    <input type="date" value="<?php echo Request('q') ?? date('Y-m-d'); ?>" style="border: none;" class="border-left form-control"
                        name="q" placeholder="Pilih Tanggal">
                    <button type="submit" style="border: none; height: 38px;"
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
                                    <th>Nama Lengkap</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Tanda Tangan</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($piket as $k => $item)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $item->nama_lengkap }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <div class="border"
                                                style="
                                            margin-left: auto;
                                            margin-right: auto;
                                            width: 100px;
                                            height: 50px;
                                            background-size: cover;
                                            background-position: center;
                                            item-align: center;
                                            @if ($item->tanda_tangan) background-image: url('{{ asset('signature') }}/{{ $item->tanda_tangan }}');
                                            @else 
                                                background-image: url('{{ asset('no_image.jpg') }}'); @endif    
                                            ">
                                            </div>
                                        </td>
                                        <td>
                                            @if (Auth::user()->role == 'Admin')
                                                <a href="#" onclick="hapusData({{ $item->id }})">
                                                    <i style="font-size: 1.5rem;" class="bi bi-trash text-danger"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            Cari tanggal untuk menampilkan data yang sesuai
                                        </td>
                                    </tr>
                                @endforelse
                                {{ $piket->links() }}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        hapusData = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"

            }).then((result) => {

                if (result.value) {
                    axios.post('/delete-piket', {
                            id
                        })
                        .then((response) => {
                            if (response.data.responCode == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    timer: 2000,
                                    showConfirmButton: false
                                })

                                location.reload();

                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Gagal...',
                                    text: response.data.respon,
                                })
                            }
                        }, (error) => {
                            console.log(error);
                        });
                }

            });
        }
    </script>
@endpush
