<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    @yield('styles')
</head>

<body class="">

    @include('toko.layout.nav')

    <nav class="flex border  border-gray-200" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="#"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900  ">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                        </path>
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa-solid fa-chevron-right"></i>
                    <a href="#"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2  ">Projects</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center ">
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 ">Flowbite</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- conetent -->
    <div class=" h-screen flex w-full">
        <!-- sidebar -->
        @yield('sidebar-kategori')

        {{-- container --}}
        @yield('container')

    </div>
    <script>
        const sidebar = document.getElementById('sidebar')
        const filterToggle = document.getElementsByClassName('btn-filter-toggle');

        for (let i = 0; i < filterToggle.length; i++) {
            filterToggle[i].addEventListener('click', function(e) {
                filterToggle[0].classList.toggle('hidden')

                if (sidebar.classList.contains('hidden')) {
                    filterToggle[1].classList.add('hidden')
                } else {
                    filterToggle[1].classList.remove('hidden')
                }
                sidebar.classList.toggle('hidden')

            })
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    @yield('search_script')
    @yield('script')

    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
</body>

</html>
