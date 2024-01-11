@extends('backend.app')
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
            margin-left: 1rem; /* Sesuaikan nilai margin kiri sesuai kebutuhan */
        }

        .judul_berita{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            height: 42px;
        }
    </style>
@endpush
@section('content')
    <a data-toggle="modal" data-target="#modal" href="#" class="bg-primary act-btn">
        +
    </a>
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 px-1">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Foto Kegiatan</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group shadow mb-3 mt-3">
                    {{-- <input type="text" value="{{ Request('q') }}" style="border: none;" class="form-control" name="q"
                        placeholder="Type to Search or Clear to See All Data ..."> --}}
                    <select class="form-control" style="border: none;" name="q" id="q">
                        <option value="">Change to Search or Clear to See All Data</option>
                        <option>Kegiatan Lainnya</option>
                        <option>Rapat Anggota Inti</option>
                        <option>Rapat Seluruh Anggota</option>
                        <option>Rapat Konsultasi</option>
                        <?php $agenda = DB::table('agendas')->get(); ?>
                        @foreach ($agenda as $item)
                            <option>{{ $item->kegiatan }}</option>
                        @endforeach
                    </select>
                    <button onclick="showLoadingIndicator()" type="submit" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border: none; height: 38px;" class="input-group-text bg-primary text-white"
                        id="basic-addon2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($data as $k => $item)
            <div class="col-lg-3 col-6 px-1">
                <div class="card shadow mb-4">
                    <div style="
                        border-radius: 8px;
                        border-radius: 8px;
                        width: 100%;
                        aspect-ratio: 1/1;
                        background-position: center;
                        background-size: cover;
                        @if($item->foto_kegiatan)
                            background-image: url('{{ asset('foto_kegiatan') }}/{{ $item->foto_kegiatan }}') 
                        @else
                            background-image: url('{{ asset('no_image.jpg') }}') 
                        @endif
                        ">
                        <a href="#" onclick="hapusData({{ @@$item->id }})" class="m-1 badge bg-danger text-white"
                            style="border-radius: 5px;">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        @endforeach
        {{ $data->links() }}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">foto-kegiatan Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        
                        <div class="form-group">
                            <label>Nama Kegiatan <sup class="text-danger">*</sup></label>
                            <select class="form-control" required name="nama_kegiatan" id="nama_kegiatan">
                                <option value="">--PILIH JENIS KEGIATAN</option>
                                <option>Kegiatan Lainnya</option>
                                <option>Rapat Anggota Inti</option>
                                <option>Rapat Seluruh Anggota</option>
                                <option>Rapat Konsultasi</option>
                                <?php $agenda = DB::table('agendas')->get(); ?>
                                @foreach ($agenda as $item)
                                    <option>{{ $item->kegiatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Foto Kegiatan</label>
                            <input name="foto_kegiatan" id="foto_kegiatan" type="file" placeholder="foto"
                                class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="modal-footer p-3 d-flex align-items-end d-flex align-items-end">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">Close</button>
                            <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-foto-kegiatan' : '/update-foto-kegiatan',
                    data: formData,
                })
                .then(function(res) {
                    //handle success         
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        location.reload();

                    } else {

                        console.log('terjadi error');
                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function(res) {
                    document.getElementById("tombol_kirim").disabled = false;
                    //handle error
                    console.log(res);
                });
        }

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
                    axios.post('/delete-foto-kegiatan', {
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
