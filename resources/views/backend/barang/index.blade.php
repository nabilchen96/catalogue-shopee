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
            height: 42px;
        }

        th,
        td {
            white-space: nowrap !important;
        }
    </style>
@endpush
@section('content')
    <a data-toggle="modal" data-target="#modal" href="#" class="bg-primary act-btn">
        +
    </a>
    <a data-toggle="modal" data-target="#import" href="#" class="bg-success act-btn" style="bottom: 90px;">
        <i class="bi bi-file-earmark-excel" style="font-size: 1.5rem;"></i>
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
        <div class="table-responsive">
            <table class="table bg-white table-striped" style="width: 100%;">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%">No</th>
                        <th>Foto</th>
                        <th>Foto</th>
                        <th>Nama Barang</th>
                        <th>Rating</th>
                        <th>Terjual</th>
                        <th>Harga Start</th>
                        <th>Harga End</th>
                        <th>Link Afiliasi</th>
                        <th>Created</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $k => $item)
                        <tr>
                            <td>{{ $k + 1 }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="shadow border"
                                        style="
                                    margin-left: auto;
                                    margin-right: auto;
                                    width: 115px;
                                    height: 115px;
                                    background-size: cover;
                                    background-position: center;
                                    item-align: center;
                                    @if ($item->foto_pertama) background-image: url('{{ asset('foto_pertama') }}/{{ $item->foto_pertama }}');
                                    @else 
                                        background-image: url('{{ asset('no_image.jpg') }}'); @endif    
                                    ">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="shadow mr-2 border"
                                        style="
                                    margin-left: auto;
                                    margin-right: auto;
                                    width: 50px;
                                    height: 50px;
                                    background-size: cover;
                                    background-position: center;
                                    item-align: center;
                                    @if ($item->foto_kedua) background-image: url('{{ asset('foto_kedua') }}/{{ $item->foto_kedua }}');
                                    @else 
                                        background-image: url('{{ asset('no_image.jpg') }}'); @endif    
                                    ">
                                    </div>
                                    <div class="shadow border"
                                        style="
                                    margin-left: auto;
                                    margin-right: auto;
                                    width: 50px;
                                    height: 50px;
                                    background-size: cover;
                                    background-position: center;
                                    item-align: center;
                                    @if ($item->foto_ketiga) background-image: url('{{ asset('foto_ketiga') }}/{{ $item->foto_ketiga }}');
                                    @else 
                                        background-image: url('{{ asset('no_image.jpg') }}'); @endif    
                                    ">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="shadow mr-2 border"
                                        style="
                                    margin-left: auto;
                                    margin-right: auto;
                                    width: 50px;
                                    height: 50px;
                                    background-size: cover;
                                    background-position: center;
                                    item-align: center;
                                    @if ($item->foto_keempat) background-image: url('{{ asset('foto_keempat') }}/{{ $item->foto_keempat }}');
                                    @else 
                                        background-image: url('{{ asset('no_image.jpg') }}'); @endif    
                                    ">
                                    </div>
                                    <div class="shadow border"
                                        style="
                                    margin-left: auto;
                                    margin-right: auto;
                                    width: 50px;
                                    height: 50px;
                                    background-size: cover;
                                    background-position: center;
                                    item-align: center;
                                    @if ($item->foto_kelima) background-image: url('{{ asset('foto_kelima') }}/{{ $item->foto_kelima }}');
                                    @else 
                                        background-image: url('{{ asset('no_image.jpg') }}'); @endif    
                                    ">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div
                                    style="width: 300px !important; white-space: normal !important; word-wrap: break-word;">
                                    {{ $item->nama_barang }}
                                </div>
                                <br>
                                <p><b><i>{{ $item->kategori }}</i></b></p>
                                <a data-item="{{ json_encode($item) }}" href="" data-toggle="modal" data-target="#upload_gambar">
                                    <i class="bi bi-card-image"></i> Upload Gambar
                                </a>
                            </td>
                            <td>{{ $item->rating }}</td>
                            <td>{{ $item->terjual }}</td>
                            <td>Rp. {{ number_format($item->harga_start) }}</td>
                            <td>Rp. {{ number_format($item->harga_end) }}</td>
                            <td><a target="_blank" href="{{ $item->afiliasi_url }}">{{ $item->afiliasi_url }}</a></td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#modal" data-item="{{ json_encode($item) }}"
                                    href="javascript:void(0)">
                                    <i style="font-size: 1.5rem;" class="bi bi-grid"></i>
                                </a>
                            </td>
                            <td>
                                @if (Auth::user()->role == 'Admin')
                                    <a href="#" onclick="hapusData({{ $item->id }})">
                                        <i style="font-size: 1.5rem;" class="bi bi-trash text-danger"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <div class="row mt-4">
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
                            <label>Harga Mulai <sup class="text-danger">*</sup></label>
                            <input name="harga_start" id="harga_start" type="number" placeholder="Harga Mulai"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Sampai <sup class="text-danger">*</sup></label>
                            <input name="harga_end" id="harga_end" type="number" placeholder="Harga Sampai"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Rating <sup class="text-danger">*</sup></label>
                            <input name="rating" id="rating" type="text" placeholder="Rating"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Terjual<sup class="text-danger">*</sup></label>
                            <input name="terjual" id="terjual" type="text" placeholder="Terjual"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Afiliasi URL<sup class="text-danger">*</sup></label>
                            <input name="afiliasi_url" id="afiliasi_url" type="text" placeholder="Terjual"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Status<sup class="text-danger">*</sup></label>
                            <select name="status" id="status" class="form-control form-control-sm" required>
                                <option>Aktif</option>
                                <option>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategori<sup class="text-danger">*</sup></label>
                            <select name="kategori" id="kategori" class="form-control form-control-sm" required>
                                <option>Laptop</option>
                                <option>Smartphone</option>
                                <option>Smartwatch</option>
                                <option>Sneakers Pria</option>
                                <option>Sneakers Wanita</option>
                                <option>Tas Wanita</option>
                                <option>TWS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Foto Pertama</label>
                            <input name="foto_pertama" id="foto_pertama" type="file" placeholder="foto"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Foto kedua</label>
                            <input name="foto_kedua" id="foto_kedua" type="file" placeholder="foto"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Foto ketiga</label>
                            <input name="foto_ketiga" id="foto_ketiga" type="file" placeholder="foto"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Foto keempat</label>
                            <input name="foto_keempat" id="foto_keempat" type="file" placeholder="foto"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Foto kelima</label>
                            <input name="foto_kelima" id="foto_kelima" type="file" placeholder="foto"
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

    <div class="modal fade" id="import" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('import-barang') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">barang Form</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>File</label>
                            <input name="file" id="file" type="file" placeholder="File"
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

    <div class="modal fade" id="upload_gambar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('upload-gambar-barang') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">upload gambar Form</h5>
                    </div>
                    <input type="hidden" id="id_barang" name="id_barang">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>File</label>
                            <input name="images[]" multiple id="file" type="file" placeholder="File"
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
                modal.find('#harga_start').val(recipient.harga_start);
                modal.find('#harga_end').val(recipient.harga_end);
                modal.find('#rating').val(recipient.rating);
                modal.find('#terjual').val(recipient.terjual);
                modal.find('#kategori').val(recipient.kategori);
                modal.find('#afiliasi_url').val(recipient.afiliasi_url);
                modal.find('#status').val(recipient.status);
            }
        })

        $('#upload_gambar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('item') // Extract info from data-* attributes

            if (recipient) {
                var modal = $(this);
                modal.find('#id_barang').val(recipient.id);
            }
        })
    </script>
@endpush
