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
                    <h3 class="font-weight-bold">Data User</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group mb-3 mt-3">
                    <input type="text" value="{{ Request('q') }}" style="border: none;" class="form-control" name="q"
                        placeholder="Type to Search or Clear to See All Data ...">
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
            @foreach ($user as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <p><i class="bi bi-person"></i>
                            <span class="text-danger">
                                {{ $item->name }}
                            </span>
                        </p>
                        <p><i class="bi bi-envelope"></i> {{ $item->email }} </p>
                        <p><i class="bi bi-telephone"></i> {{ $item->no_telp }}</p>
                        <span class="badge bg-info text-white" style="border-radius: 8px;">{{ $item->role }}</span>
                        <a data-toggle="modal" data-target="#modal" data-item="{{ json_encode($item) }}"
                            href="javascript:void(0)" class="badge bg-info text-white" style="border-radius: 8px;">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="#" onclick="hapusData({{ $item->id }})" class="badge bg-danger text-white"
                            style="border-radius: 8px;">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            @endforeach
            {{ $user->links() }}
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">User Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input name="email" id="email" type="email" placeholder="email"
                                class="form-control form-control-sm" required>
                            <span class="text-danger error" style="font-size: 12px;" id="email_alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Lengkap</label>
                            <input name="name" id="name" type="text" placeholder="Nama Lengkap"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telpon</label>
                            <input name="no_telp" id="no_telp" type="number" placeholder="No Telpon"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input name="password" id="password" type="password" placeholder="Password"
                                class="form-control form-control-sm" required>
                            <span class="text-danger error" style="font-size: 12px;" id="password_alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Role</label>
                            <select name="role" class="form-control" id="role" required>
                                <option>Admin</option>
                                <option>Ekonomi</option>
                                <option>Umum</option>
                                <option>Sekretariat</option>
                                <option>Sosial</option>
                                <option>Pendidikan</option>
                            </select>
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
                    url: formData.get('id') == '' ? '/store-user' : '/update-user',
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
                    axios.post('/delete-user', {
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
                modal.find('#name').val(recipient.name);
                modal.find('#email').val(recipient.email);
                modal.find('#no_telp').val(recipient.no_telp);
                modal.find('#role').val(recipient.role);
            }
        })
    </script>
@endpush
