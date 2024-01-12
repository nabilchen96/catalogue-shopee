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
                    <h3 class="font-weight-bold">Data Barang</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group mb-4 mt-3">
                    <input type="text" value="{{ Request('q') }}" style="border: none;" class="form-control" name="q"
                        placeholder="Type to Search or Clear to See All Data ...">
                    <button onclick="showLoadingIndicator()" type="submit" style="border: none; height: 38px;" class="input-group-text bg-primary text-white"
                        id="basic-addon2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($barang as $k => $item)
            <div class="col-lg-3 col-6 px-1">
                <div class="card shadow mb-4">
                    <div style="
                        border-top-left-radius: 8px;
                        border-top-right-radius: 8px;
                        width: 100%;
                        aspect-ratio: 1/1;
                        background-position: center;
                        background-size: cover;
                        @if($item->foto_barang)
                            background-image: url('{{ asset('foto_barang') }}/{{ $item->foto_barang }}');
                        @else 
                            background-image: url('{{ asset('no_image.jpg') }}');
                        @endif
                        ">

                    </div>
                    <div class="card-body p-3">
                        <p class="judul_berita mt-0 mb-2">{{ $item->nama_barang }}</p>
                        @if (Auth::id() == $item->id_user)   
                            <a data-toggle="modal" data-target="#modal" data-item="{{ json_encode(@@$item) }}" href="javascript:void(0)"
                                class="badge bg-info text-white" style="border-radius: 8px;">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="#" onclick="hapusData({{ @@$item->id }})" class="badge bg-danger text-white"
                                style="border-radius: 8px;">
                                <i class="bi bi-trash"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        {{ $barang->links() }}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">barang Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Nama Barang <sup class="text-danger">*</sup></label>
                            <input name="nama_barang" id="nama_barang" type="text" placeholder="Nama Barang"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan <sup class="text-danger">*</sup></label>
                            <textarea name="keterangan" id="keterangan" placeholder="Keterangan" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Foto Barang</label>
                            <input name="foto_barang" id="foto_barang" type="file" placeholder="foto"
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
                    url: formData.get('id') == '' ? '/store-barang' : '/update-barang',
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
                    axios.post('/delete-barang', {
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

        $('#modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('item') // Extract info from data-* attributes

            console.log(recipient);

            document.getElementById("form").reset();
            document.getElementById('id').value = ''
            $('.error').empty();

            if (recipient) {
                var modal = $(this);
                modal.find('#id').val(recipient.id);
                modal.find('#nama_barang').val(recipient.nama_barang);
                modal.find('#keterangan').val(recipient.keterangan);
            }
        })
    </script>
@endpush
