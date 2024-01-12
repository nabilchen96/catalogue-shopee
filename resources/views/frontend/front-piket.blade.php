<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="login-form-02/fonts/icomoon/style.css">

    <link rel="stylesheet" href="login-form-02/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="login-form-02/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="login-form-02/css/style.css">

    <title>Aplikasi Kegiatan IAD Kaur</title>
    <style>
        .form-control {
            height: 35px !important;
        }
    </style>
</head>

<body>
    <div class="d-lg-flex half" style="min-height: 750px !important;">
        <div class="bg order-1 order-md-2" style="background-image: url('natural.png');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 mt-2">
                        Formulir
                        <h3>Absensi Piket</h3>
                        <p>Anggota IAD Kaur</p>
                        <br>
                        <form id="form">
                            <div class="form-group first">
                                <label for="username">Nama Anggota</label>
                                <select name="nama_pengurus" id="nama_pengurus" class="form-control" required>
                                    <option value="">--PILIH NAMA ANGGOTA--</option>
                                    <?php $anggota = DB::table('anggotas')->get(); ?>
                                    @foreach ($anggota as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group first">
                                <label for="username">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                            </div>
                           
                            <div class="form-group last mb-3">
                                <label>Tanda Tangan <sup class="text-danger">*</sup></label>
                                <div id="signature-alert"></div>
                                <div>
                                    <canvas
                                        style="border: 1px solid #ccc;
                      border-radius: 0.5rem;
                      width: 100%;
                      background: white;
                      height: 200px;"
                                        id="signature-pad" class="signature-pad"></canvas>
                                </div>
                                <input type="hidden" name="ttd" id="nilaittd">
                                <div>
                                    <button style="height: 50%;" type="button" class="btn btn-dark" id="undo">
                                        <span class="fas fa-undo"></span> Undo</button>
                                    <button style="height: 50%;" type="button" class="btn btn-danger" id="clear">
                                        <span class="fas fa-eraser"></span> Clear</button>
                                </div>
                            </div>


                            <div class="d-grid">
                                <button type="submit" id="btnLogin"
                                    class="btn btn-primary btn-lg btn-block">Submit</button>

                                <button style="display: none; background: #0d6efd;" id="btnLoginLoading"
                                    class="btn btn-info btn-moodle text-white btn-lg btn-block" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

                                </button>
                            </div>
                            <br>
                        </form>
                        <a onclick="showLoadingIndicator()" href="{{ url('/') }}" style="text-decoration: none;" type="submit" id="btnLogin" class="text-white btn btn-info btn-lg btn-block">
                            🏠 Kembali
                          </a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            // window.onresize = resizeCanvas;
            resizeCanvas();
        })

        var canvas = document.getElementById('signature-pad');

        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
        });

        document.getElementById('clear').addEventListener('click', function() {
            signaturePad.clear();
        });

        document.getElementById('undo').addEventListener('click', function() {
            var data = signaturePad.toData();
            if (data) {
                data.pop(); // remove the last dot or line
                signaturePad.fromData(data);
            }
        });

        signaturePad.toDataURL(); // save image as PNG

        // Returns signature image as an array of point groups
        const data = signaturePad.toData();

        // Draws signature image from an array of point groups
        signaturePad.fromData(data);

        // Unbinds all event handlers
        signaturePad.off();

        // Rebinds all event handlers
        signaturePad.on();

        form.onsubmit = (e) => {

            e.preventDefault();

            document.getElementById("btnLoginLoading").disabled = true;

            if (signaturePad.isEmpty()) {
                
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: `Maaf, silahkan isi tanda tangan terlebih dahulu sebelum mengirim data!`,
                    timer: 3000,
                    showConfirmButton: false
                })

                document.getElementById("btnLoginLoading").disabled = false;
            } else {
              
                $("#nilaittd").val(signaturePad.toDataURL())
                let formData = new FormData(form);

                axios({
                        method: 'post',
                        url: '/piket-store',
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

                            location.reload()

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: res.data.respon,
                                timer: 3000,
                                showConfirmButton: false
                            })

                            document.getElementById("btnLoginLoading").disabled = false;
                        }
                    })
                    .catch(function(res) {
                        //handle error
                        console.log(res);
                    });
            }

        }
    </script>


</body>

</html>
