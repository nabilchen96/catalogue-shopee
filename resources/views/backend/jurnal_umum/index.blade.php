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
    <a data-toggle="modal" data-target="#modal" style="bottom: 90px !important;" href="{{ url('store-jurnal-umum') }}"
        class="bg-primary act-btn">
        +
    </a>

    <a href="{{ url('export-pdf-jurnal-umum') }}" class="bg-danger act-btn"><i style="font-size: 20px;"
            class="bi bi-file-earmark-pdf"></i></a>
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 px-1">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Jurnal Umum</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group shadow mb-3 mt-3">
                    <input type="date" value="{{ Request('tgl_awal') ?? date('Y-m-d') }}" style="border: none;"
                        class="form-control" name="tgl_awal" required placeholder="Tanggal Awal">
                    <input type="date" value="{{ Request('tgl_akhir') ?? date('Y-m-d') }}" style="border: none;"
                        class="border-left form-control" name="tgl_akhir" required placeholder="Tanggal Akhir"
                        aria-placeholder="Tanggal Akhir">
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
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $debit = 0; $kredit = 0; ?>
                                @foreach ($jurnal as $k => $item)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $item->waktu_transaksi }}</td>
                                        <td>
                                            <p
                                                style="max-width: 300px; white-space: normal !important; word-wrap: break-word;">
                                                {{ $item->keterangan }}
                                            </p>
                                        </td>
                                        <td>Rp. {{ number_format($item->debet) }}</td>
                                        <td>Rp. {{ number_format($item->kredit) }}</td>
                                        <td></td>
                                        <td>
                                            <a href="#" onclick="hapusData({{ $item->id }})">
                                                <i style="font-size: 1.5rem;" class="bi bi-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                        $debit += $item->debet;
                                        $kredit += $item->kredit;
                                    ?>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        Rp. {{ number_format($debit) }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($kredit) }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{ $jurnal->links() }}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Jurnal Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Keterangan <sup class="text-danger">*</sup></label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Transaksi <sup class="text-danger">*</sup></label>
                            <input name="tanggal_transaksi" id="tanggal_transaksi" type="datetime-local" placeholder="Debit"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Debit</label>
                            <input name="debet" id="debet" type="number" placeholder="Debit"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Kredit</label>
                            <input name="kredit" id="kredit" type="number" placeholder="Kredit"
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
                    url: formData.get('id') == '' ? '/store-jurnal-umum' : '/update-jurnal-umum',
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
                    axios.post('/delete-jurnal-umum', {
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
