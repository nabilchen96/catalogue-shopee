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

        i {
            font-size: 14px !important;
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
                    <h3 class="font-weight-bold">Data Cicilan</h3>
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
            @foreach ($cicilan as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <p><i class="bi bi-person"></i>
                            <span class="text-danger">
                                {{ @$item->nama_konsumen }}
                            </span>
                        </p>
                        <p><i class="bi bi-box-seam"></i>
                            {{ @$item->nama_barang }}
                        </p>
                        <p><i class="bi bi-calendar3"></i>
                            {{ date('d/m/Y', strtotime(@$item->tanggal_angsuran)) }}
                        </p>
                        <hr>
                        <p>
                            <b>Sisa cicilan</b> <br>
                            Rp. {{ number_format(@$item->total_cicilan) }}
                        </p>
                        <p>
                            <b>Pembayaran</b> <br>
                        <h4 class="text-danger mb-3">Rp. {{ number_format(@$item->angsuran) }}</h4>
                        </p>
                        {{-- <a data-toggle="modal" data-target="#modal" data-item="{{ json_encode(@$item) }}"
                            href="javascript:void(0)" class="badge bg-info text-white" style="border-radius: 8px;">
                            <i class="bi bi-pencil-square"></i>
                        </a> --}}
                        <a href="#" onclick="hapusData({{ @$item->id }})" class="badge bg-danger text-white"
                            style="border-radius: 8px;">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Cicilan Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Cicilan Barang <sup class="text-danger">*</sup></label>
                            <select onchange="cariData()" name="id_penjualan" id="id_penjualan"
                                class="form-control form-control-sm" required>
                                <option value="">--PILIH CICILAN BARANG--</option>
                                <?php
                                $brg = DB::table('cicilans as c')
                                    ->join('penjualans as p', 'p.id', '=', 'c.id_penjualan')
                                    ->join('barangs as b', 'b.id', '=', 'p.id_barang')
                                    ->select('p.*', 'b.nama_barang', 'c.total_cicilan')
                                    ->whereIn('c.id', function ($query) {
                                        $query
                                            ->select(DB::raw('MAX(id)'))
                                            ->from('cicilans')
                                            ->groupBy('id_penjualan');
                                    })
                                    ->whereNotIn('total_cicilan', [
                                        0
                                    ])
                                    ->orderBy('c.id', 'DESC')
                                    ->get();
                                ?>
                                @foreach ($brg as $item)
                                    <option value2="{{ $item->total_cicilan }}" value="{{ $item->id }}">
                                        {{ $item->nama_konsumen }} - {{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sisa Cicilan <sup class="text-danger">*</sup></label>
                            <input type="hidden" name="sisa_cicilan" id="sisa_cicilan">
                            <input id="sisa_cicilan1" placeholder="Sisa Cicilan" class="form-control form-control-sm"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Angsuran <sup class="text-danger">*</sup></label>
                            <input type="number" placeholder="Angsuran" name="angsuran"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Angsuran <sup class="text-danger">*</sup></label>
                            <input name="tanggal_angsuran" id="tanggal_angsuran" placeholder="Tanggal Angsuran"
                                class="form-control form-control-sm" required type="date">
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
        function cariData() {
            var selectElement = document.getElementById("id_penjualan");
            var selectedIndex = selectElement.selectedIndex;
            var selectedOption = selectElement.options[selectedIndex];

            var data2 = parseInt(selectedOption.getAttribute("value2"));

            document.getElementById('sisa_cicilan').value = data2
            document.getElementById('sisa_cicilan1').value = data2.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            })
        }
        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-cicilan' : '/update-cicilan',
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
                    axios.post('/delete-cicilan', {
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
                modal.find('#nama_lengkap').val(recipient.nama_lengkap);
                modal.find('#no_cicilan').val(recipient.no_cicilan);
                modal.find('#jabatan').val(recipient.jabatan);
                modal.find('#tempat_lahir').val(recipient.tempat_lahir);
                modal.find('#tanggal_lahir').val(recipient.tanggal_lahir);
                modal.find('#agama').val(recipient.agama);
                modal.find('#alamat').val(recipient.alamat);
                modal.find('#no_telp').val(recipient.no_telp);
                modal.find('#keterangan').val(recipient.keterangan);
            }
        })
    </script>
@endpush
