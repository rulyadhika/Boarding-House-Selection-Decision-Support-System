<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ $title }} - Cari Kost</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- datatables -->
    <link href="{{ asset('src/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('src/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('src/css/loader.css') }}">

    <link rel="icon" href="" />

    @livewireStyles

</head>

<body class="bg-gray-900">
    <div id="loader" class="d-none">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <img src="{{ asset('src/images/Dual Ring-1s-200px.svg') }}" alt="">
            <h6>Silahkan Tunggu...</h6>
        </div>
    </div>

    <div class="container">
        {{ $slot }}
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('src/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('src/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('src/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('src/js/sb-admin-2.min.js') }}"></script>

    @livewireScripts

    <script>
        window.onload = function() {
            Livewire.hook('message.sent', () => {
                window.dispatchEvent(
                    new CustomEvent('loading', {
                        detail: {
                            loading: true
                        }
                    })
                );
            })
            Livewire.hook('message.processed', (message, component) => {
                window.dispatchEvent(
                    new CustomEvent('loading', {
                        detail: {
                            loading: false
                        }
                    })
                );
            })
        }

        window.addEventListener('loading', (event) => {
            $("#loader").toggleClass('d-none');
        });
    </script>

</body>

</html>
