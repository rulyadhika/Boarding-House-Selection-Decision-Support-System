<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="{{ asset('src/css/loader.css') }}">

    @livewireStyles

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .fw-medium {
            font-weight: 600;
        }

        .carousel-item {
            height: 550px;
        }
        
        .carousel-item img {
            filter: brightness(40%);
        }

        .banner-text {
            position: absolute;
            color: white;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

    </style>

    @stack('pageStyle')
</head>

<body>
    <div id="loader" class="d-none">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <img src="{{ asset('src/images/Dual Ring-1s-200px.svg') }}" alt="">
            <h6>Silahkan Tunggu...</h6>
        </div>
    </div>

    @livewire('frontend.components.navbar')

    <div id="carouselExampleControls" class="carousel slide position-relative" data-bs-ride="carousel">
        <div class="banner-text text-center">
            <h5>Rekomendasi Pemilihan Kost Menggunakan Metode SAW</h5>
            <h5 class="fst-italic">(Simple Additive Weighting)</h5>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://source.unsplash.com/2gDwlIim3Uw?w=1024&h=500" class="d-block w-100"
                    alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/MP0bgaS_d1c?w=1024&h=500" class="d-block w-100"
                    alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/jn7uVeCdf6U?w=1024&h=500" class="d-block w-100"
                    alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="main-container my-5">
        {{ $slot }}
    </div>

    @livewire('frontend.components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <!-- swal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.6/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('src/js/swalBtn.js') }}"></script>
    <script src="{{ asset('src/js/swalDialog.js') }}"></script>

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

    <script>
        Livewire.on('failedAction', (response) => {
            dispatchErrorDialog(response);
        });
    </script>

    @stack('pageScript')
</body>

</html>
