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
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
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
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Projects</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center ">
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Flowbite</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- conetent -->
    <div class=" h-screen flex w-full">
        <!-- sidebar -->
        @if (request()->is('list-item'))
            <aside class="md:w-80 border-r-2  transition-width" id="sidebar" aria-label="Sidebar">
                <button class="p-4 flex justify-between font-light  w-full btn-filter-toggle">
                    <span class="text-sm">Sembunyikan Filter </span><i class="fa-solid fa-bars"></i>
                </button>
                <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
                    <ul class="space-y-2">
                        <li>
                            <a href="#"
                                class=" text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="flex items-center p-2">

                                    <span class="flex-1 ml-3 whitespace-nowrap">Kategori</span>
                                    <br>
                                </div>
                                <ul class="px-5">
                                    <li>
                                        <div class="flex items-center mb-4">
                                            <input id="default-checkbox" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-checkbox"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Sepatu</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center mb-4">
                                            <input id="default-checkbox" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-checkbox"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Kaos</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center mb-4">
                                            <input id="default-checkbox" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-checkbox"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Hodie</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center mb-4">
                                            <input id="default-checkbox" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-checkbox"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Topi</label>
                                        </div>
                                    </li>

                                </ul>



                            </a>
                        </li>

                    </ul>
                </div>
            </aside>
        @endif

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
    @yield('script')
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
</body>

</html>
