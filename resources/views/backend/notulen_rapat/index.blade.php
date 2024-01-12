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
                    <h3 class="font-weight-bold">Data Notulen Rapat</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group shadow mb-3 mt-3">
                    <input type="date" value="{{ Request('q') }}" style="border: none;" class="border-left form-control"
                        name="q" value="{{ Request('q') ?? date('Y-m-d') }}">
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
            @foreach ($data as $k => $item)
                <div class="col-lg-12 mb-3 px-1">
                    <div class="card shadow">
                        <div class="card-body" style="padding: 1.25rem;">
                            <div class=""
                                style="border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;"
                                id="headingOne">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>
                                            <i class="bi bi-boxes"></i>
                                            <span class="text-danger">
                                                {{ @$item->jenis_rapat }}
                                            </span>
                                        </p>
                                        <p><i class="bi bi-calendar3"></i>
                                            {{ date('d/m/Y', strtotime(@$item->tanggal_rapat)) }}
                                        </p>
                                        <p>
                                            <i class="bi bi-geo-alt"></i>
                                            {{ @$item->tempat }}
                                        </p>
                                        <p>
                                            <i class="bi bi-people"></i>
                                            {{ @$item->total_hadir }} Orang
                                        </p>
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
                                        <b>Pimpinan</b><br>
                                        {{ @$item->pimpinan }}
                                    </p>
                                    <p>
                                        <b>Acara</b><br>
                                        {{ @$item->acara }}
                                    <p>
                                        <b>Hasil Rapat</b><br>
                                        {{ @$item->hasil }}
                                    </p>
                                    @if (Auth::id() == $item->id_user)
                                        <a data-toggle="modal" data-target="#modal" data-item="{{ json_encode(@$item) }}"
                                            href="javascript:void(0)" class="badge bg-info text-white"
                                            style="border-radius: 8px;">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
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
            {{ $data->links() }}
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Notulen Rapat Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group last mb-3">
                            <label for="password">Jenis Rapat</label>
                            <select name="jenis_rapat" id="jenis_rapat" class="form-control" required>
                                <option value="">--PILIH JENIS RAPAT--</option>
                                <option>Rapat Anggota Inti</option>
                                <option>Rapat Seluruh Anggota</option>
                                <option>Rapat Konsultasi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Rapat<sup class="text-danger">*</sup></label>
                            <input name="tanggal_rapat" type="date" id="tanggal_rapat" placeholder="Tanggal Surat"
                                class="form-control form-control-sm" required>
                        </div>

                        <div class="form-group">
                            <label>Tempat<sup class="text-danger">*</sup></label>
                            <input name="tempat" type="text" id="tempat" placeholder="Tempat"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>pimpinan<sup class="text-danger">*</sup></label>
                            <input name="pimpinan" type="text" id="pimpinan" placeholder="pimpinan"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>total_hadir<sup class="text-danger">*</sup></label>
                            <input name="total_hadir" type="number" id="total_hadir" placeholder="total_hadir"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Acara <sup class="text-danger">*</sup></label>
                            <input name="acara" type="text" id="acara" placeholder="acara"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Hasil</label>
                            <textarea name="hasil" id="hasil" cols="30" rows="5" class="form-control form-control-sm"
                                placeholder="hasil"></textarea>
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
                    url: formData.get('id') == '' ? '/store-notulen-rapat' : '/update-notulen-rapat',
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
                    axios.post('/delete-notulen-rapat', {
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
                modal.find('#jenis_rapat').val(recipient.jenis_rapat);
                modal.find('#tanggal_rapat').val(recipient.tanggal_rapat);
                modal.find('#tempat').val(recipient.tempat);
                modal.find('#acara').val(recipient.acara);
                modal.find('#total_hadir').val(recipient.total_hadir);
                modal.find('#pimpinan').val(recipient.pimpinan);
                modal.find('#hasil').val(recipient.hasil);
            }
        })
    </script>
@endpush
