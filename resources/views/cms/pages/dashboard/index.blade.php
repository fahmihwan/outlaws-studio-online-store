@extends('cms.layouts.main')


@section('container')
    <div class="w-full  ">
        <nav class="flex justify-between mb-4 p-2 bg-white shadow-md text-black rounded-md" aria-label="Breadcrumb ">
            <div class="font-bold text-2xl text-gray-700">
                Dashboard
            </div>
            <div>
                <ol class="inline-flex items-center space-x-1 md:space-x-3  ">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-sm font-medium  hover:text-gray-900">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-400"></i>
                            <a href="#" class="ml-1 text-sm font-medium hover:text-gray-900 md:ml-2 ">Projects</a>
                        </div>
                    </li>
                </ol>
            </div>
        </nav>

        <div class="w-full flex">
            <div class="w-3/5">
                <div class="mb-5 flex">
                    <div class="bg-purple-800 w-1/3 mr-2 rounded shadow-md p-3">
                        <div class="text-white">
                            <p>Transaksi Bulan ini</p>
                            <span class="font-bold">20</span>
                        </div>
                    </div>
                    <div class="bg-purple-800 w-1/3 mr-2 rounded shadow-md p-3">
                        <div class="text-white">
                            <p>Produk Terjual Bulan ini</p>
                            <span class="font-bold">20</span>
                        </div>
                    </div>
                    <div class="bg-purple-800 w-1/3 mr-2 rounded shadow-md p-3">
                        <div class="text-white">
                            <p>Jumlah Pengguna</p>
                            <span class="font-bold">20</span>
                        </div>
                    </div>

                </div>

                <div class="w-full shadow-md bg-white rounded-md p-3 ">

                    Dashboard <br>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
            <div class="w-2/5">
                <div class="bg-white shadow-md rounded-md mx-3">
                    <div class="p-5">
                        <h1 class="font-bold mb-5 ">Transaksi Baru</h1>
                        <div class=" h-96 overflow-scroll rounded-lg  px-5 bg-gray-50">
                            <ul>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                                <li class="pb-2 mb-3 border-b border-purple-400 flex justify-between"><a href=""
                                        class=" ">fahmiihwan86@gmail.com</a> <span
                                        class="text-gray-400">2022-02-12</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
