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
                    <h3 class="font-weight-bold">Data Penjualan</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group mb-3 mt-3">
                    <input type="date" value="{{ Request('tgl_awal') ?? date('Y-m-d') }}" style="border: none;" class="form-control"
                        name="tgl_awal" required>
                    <input type="date" value="{{ Request('tgl_akhir') ?? date('Y-m-d') }}" style="border: none;" class="border-left form-control"
                        name="tgl_akhir" required>
                    <button onclick="showLoadingIndicator()" type="submit" style="border: none; height: 38px;"
                        class="input-group-text bg-primary text-white" id="basic-addon2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="accordion" id="accordionExample">
        <div class="row">
            @foreach ($penjualan as $k => $item)
                <div class="col-lg-12 mb-3 px-1">
                    <div class="card shadow">
                        <div class="card-body" style="padding: 1.25rem;">
                            <div class=""
                                style="border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;"
                                id="headingOne">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p><i class="bi bi-person"></i>
                                            <span class="text-danger">
                                                {{ @$item->nama_konsumen }}
                                            </span>
                                        </p>
                                        <p><i class="bi bi-box-seam"></i>
                                            {{ @$item->nama_barang }}
                                        </p>
                                        <p><i class="bi bi-calendar3"></i>
                                            <span>
                                                {{ date('d/m/Y', strtotime(@$item->tanggal_penjualan)) }}
                                            </span>
                                        </p>
                                        <p><i class="bi bi-grid"></i>
                                            <span>
                                                Total Item: {{ @$item->jumlah_penjualan }} Item
                                            </span>
                                        </p>
                                        <br>
                                        <div class="d-flex">
                                            @if ($item->foto_barang)
                                                <img class="border mr-3" width="50px" height="50px" src="{{ asset('foto_barang') }}/{{ $item->foto_barang }}" alt="">
                                            @else 
                                                <img class="border mr-3" width="50px" height="50px" src="{{ asset('no_image.jpg') }}" alt="">
                                            @endif
                                            <div>
                                                <p><b>Uang Konsumen</b></p>
                                                <h4>
                                                    {{-- Rp. {{ number_format(@$item->harga_jual * @$item->jumlah_penjualan) }} --}}
                                                    Rp. {{ number_format(@$item->uang_konsumen) }}
                                                    
                                                </h4>
                                            </div>

                                        </div>
                                    </div>
                                    <p data-toggle="collapse" data-target="#collapse{{ $k + 1 }}">
                                        <i class="bi bi-chevron-down"></i>
                                    </p>
                                </div>
                            </div>

                            <div id="collapse{{ $k + 1 }}" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="">
                                    <hr>
                                    <p>
                                        <b>Harga Modal</b><br>
                                        Rp. {{ number_format(@$item->harga_modal) }}
                                    </p>
                                    <p>
                                        <b>Harga Jual</b><br>
                                        Rp. {{ number_format(@$item->harga_jual) }}
                                    </p>
                                    <p>
                                        <b>Total Bayar (Harga Jual * Jumlah Item)</b><br>
                                        Rp. {{ number_format(@$item->harga_jual * @$item->jumlah_penjualan) }}
                                    </p>
                                    <p>
                                        <b>Status</b><br>
                                        @if ((@$item->harga_jual * @$item->jumlah_penjualan) <= @$item->uang_konsumen )
                                            Cash
                                        @else
                                            Kredit
                                        @endif
                                    </p>
                                    <p>
                                        <b>Keterangan</b><br>
                                        {{ @$item->keterangan }}
                                    </p>

                                    {{-- <a data-toggle="modal" data-target="#modal" data-item="{{ json_encode(@$item) }}"
                                        href="javascript:void(0)" class="badge bg-info text-white"
                                        style="border-radius: 8px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> --}}
                                    @if (Auth::id() == $item->id_user)    
                                        <a href="#" onclick="hapusData({{ @$item->id }})"
                                            class="badge bg-danger text-white" style="border-radius: 8px;">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $penjualan->links() }}
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Penjualan Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label>Nama Konsumen <sup class="text-danger">*</sup></label>
                            <input name="nama_konsumen" id="nama_konsumen" type="text"
                                placeholder="Nama Konsumen" class="form-control form-control-sm" required>
                        </div>

                        <div class="form-group">
                            <label>Barang <sup class="text-danger">*</sup></label>
                            <select onchange="cariStok()" name="id_barang" id="id_barang" class="form-control form-control-sm" required>
                                <option value="">--PILIH BARANG</option>
                                <?php $barang = DB::table('barangs')->whereNotIn('stok', [0])->get(); ?>
                                @foreach ($barang as $item)
                                    <option value2="{{ $item->stok }}" value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Sisa Stok <sup class="text-danger">*</sup></label>
                            <input id="sisa_stok" placeholder="Sisa Stok" class="form-control form-control-sm"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label>Harga Modal <sup class="text-danger">*</sup></label>
                            <input name="harga_modal" id="harga_modal" type="number"
                                placeholder="Harga Modal" class="form-control form-control-sm" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Jual <sup class="text-danger">*</sup></label>
                            <input name="harga_jual" id="harga_jual" type="number"
                                placeholder="Harga Jual" class="form-control form-control-sm" required>
                        </div>

                        <div class="form-group">
                            <label>Jumlah Item <sup class="text-danger">*</sup></label>
                            <input name="jumlah_penjualan" id="jumlah_penjualan" type="number"
                                placeholder="Jumlah Item" class="form-control form-control-sm" required>
                        </div>

                        <div class="form-group">
                            <label>Uang Konsumen <sup class="text-danger">*</sup></label>
                            <input name="uang_konsumen" id="uang_konsumen" type="number"
                                placeholder="Uang Konsumen" class="form-control form-control-sm" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Penjualan <sup class="text-danger">*</sup></label>
                            <input name="tanggal_penjualan" id="tanggal_penjualan" type="date"
                                placeholder="Tanggal Penjualan" class="form-control form-control-sm" required>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" placeholder="Keterangan" id="keterangan" cols="30" rows="5"
                                class="form-control"></textarea>
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
        function cariStok() {
            var selectElement = document.getElementById("id_barang");
            var selectedIndex = selectElement.selectedIndex;
            var selectedOption = selectElement.options[selectedIndex];

            var data2 = selectedOption.getAttribute("value2");

            document.getElementById('sisa_stok').value = data2
        }
        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-penjualan' : '/update-penjualan',
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
                    axios.post('/delete-penjualan', {
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
                modal.find('#tanggal_penjualan').val(recipient.tanggal_penjualan);
                modal.find('#harga_modal').val(recipient.harga_modal);
                modal.find('#jumlah_penjualan').val(recipient.jumlah_penjualan);
                modal.find('#keterangan').val(recipient.keterangan);
                modal.find('#id_barang').val(recipient.id_barang);
                modal.find('#nama_konsumen').val(recipient.nama_konsumen);
                modal.find('#harga_jual').val(recipient.harga_jual);
            }
        })
    </script>
@endpush
