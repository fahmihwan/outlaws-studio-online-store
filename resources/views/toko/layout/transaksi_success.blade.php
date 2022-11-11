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

    <div class="w-full h-full flex justify-center bg-gray-50">
        <div class="w-full lg:w-1/2 bg-white px-10 mt-10 ">
            <div class="pt-5 pb-5">
                <div class="bg-gray-700 mx-auto text-white w-20 h-20 flex justify-center items-center rounded-full">
                    <i class="text-5xl fa-solid fa-check"></i>
                </div>
            </div>
            <div>
                <div class="text-center">
                    <p class="font-semibold md:text-2xl">TERIMA KASIH ATAS PESANAN ANDA!</p>
                    <p class="text-sm ">Kami akan mengirimkan konfirmasi order dengan informasi detail dan
                        pengiriman.
                    </p>
                </div>
                <div class="pt-5 mb-20">
                    <table class=" w-full">
                        <tr class="border-t ">
                            <td class="text-sm md:text-lg font-semibold py-3">Nomor Order</td>
                            <td class="text-end text-sm md:text-lg font-semibold">{{ $nomor_order }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="text-sm md:text-lg font-semibold py-3">Status Pesanan</td>
                            <td class="text-end text-sm md:text-lg font-semibold">{{ $status_pesanan }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="text-sm md:text-lg font-semibold py-3">Nominal Pesanan</td>
                            <td class="text-end text-sm md:text-lg font-semibold">Rp. {{ number_format() }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="text-sm md:text-lg font-semibold py-3">Metode Pembayaran</td>
                            <td class="text-end text-sm md:text-lg font-semibold">Virtual Account Mandiri</td>
                        </tr>
                        <tr class="border-t">
                            <td class="text-sm md:text-lg font-semibold py-3">Batas Akhir Pembayaran</td>
                            <td class="text-end text-sm md:text-lg font-semibold">11 November 2022 01.32.02 WIB </td>
                        </tr>
                        <tr class="border-t">
                            <td class="text-sm md:text-lg font-semibold py-3">Kode Pembayaran</td>
                            <td class="text-end text-sm md:text-lg font-semibold">8969600900013749</td>
                        </tr>
                        <tr class="border-y">
                            <td class="text-sm md:text-lg font-semibold py-3">Nomor Order</td>
                            <td class="text-end text-sm md:text-lg font-semibold">CONV5000022033</td>
                        </tr>
                    </table>

                    <div class="font-light text-center text-sm md:text-base mt-5">
                        Apablia Anda memiliki pertanyaan sehubung dengan pesanan Anda, silakan mengirimkan email
                        ke outlawsstuido@gmail.com atau whatsaapp ke nomor 082334331124. Jam operasioanl kami adalah
                        08.00 - 21.00 WIB
                    </div>
                    <div class="mt-4 flex justify-center">
                        <button
                            class="border border-black bg-white hover:bg-black hover:text-white duration-300  px-5 py-2 mx-auto">
                            Lanjut Berbelanja
                        </button>
                    </div>

                </div>
            </div>
        </div>
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
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
</body>

</html>
