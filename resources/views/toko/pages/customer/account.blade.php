@extends('toko.layout.main')

@section('container')
    <!-- conetent -->
    <div class=" md:flex w-full mt-10">
        <!-- sidebar -->
        @include('toko.components.sidebar-account')

        {{-- informasi  --}}
        <div class=" md:w-full">
            <div class=" m-2 py-4 px-10">
                <div class=" flex">
                    <div>
                        <h1 class="font-bold text-2xl mb-7">Akun Saya</h1>
                        <h1 class="font-bold text-2xl mb-6">INFORMASI AKUN & ALAMAT</h1>
                    </div>
                    <div class="flex ml-8 mb-5 items-end">
                        <a href="/customer/order-history"
                            class="border h-6 flex items-center px-10 text-xs border-black hover:bg-black hover:text-white">
                            Lihat Semua
                        </a>
                    </div>

                </div>
                <div class="overflow-x-auto relative mb-14">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700  uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="py-3 px-6 font-extrabold">
                                    Nomor Pesanan
                                </th>
                                <th scope="col" class="py-3 px-6 font-extrabold">
                                    Tanggal Pemesanan
                                </th>
                                <th scope="col" class="py-3 px-6 font-extrabold">
                                    Kirim Ke
                                </th>
                                <th scope="col" class="py-3 px-6 font-extrabold">
                                    Total
                                </th>
                                <th scope="col" class="py-3 px-6 font-extrabold">
                                    Status
                                </th>
                                <th scope="col" class="py-3 px-6 font-extrabold">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->nota }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ $item->tanggal_pembelian }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $item->alamat->nama_depan }} {{ $item->alamat->nama_belakang }}
                                    </td>
                                    <td class="py-4 px-6">
                                        Rp. {{ number_format($item->total, 0, '', '.') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $item->pembayaran->transaction_status }}
                                    </td>
                                    <td class="py-4 px-3 text-xs">
                                        <a href="">Lihat Detail </a>&nbsp; | &nbsp;
                                        <a href="">Pesan Ulang </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <section class="mb-16">
                    <h1 class="font-bold text-2xl mb-2">INFORMASI AKUN</h1>
                    <hr class="mb-4">
                    <h5 class="font-bold text-sm">Informasi Kontak</h5>
                    <p class="text-sm text-gray-600">{{ $user->credential->nama_depan }}
                        {{ $user->credential->nama_belakang }}</p>
                    <p class="text-sm text-gray-600">
                        {{ $user->email }}
                    </p>
                    <div class="text-gray-500 text-xs mt-5">
                        <a href="" class="underline hover:text-red-900">Ubah </a>&nbsp; | &nbsp;
                        <a href="" class="underline hover:text-red-900">Ubah Kata Sandi </a>
                    </div>
                </section>

                <section>
                    <div class="flex mb-2">
                        <h1 class="font-bold text-2xl mr-10">ALAMAT</h1>
                        <a href=""
                            class="border-2 flex items-center px-10 text-xs border-black hover:bg-black hover:text-white">
                            Pengaturan
                            Alamat
                        </a>
                    </div>
                    <hr class="mb-4">
                    <h5 class="font-bold text-sm">Alamat Pengiriman</h5>
                    <p class="text-sm text-gray-600">pak sulthon</p>
                    <p class="text-sm text-gray-600">maospati, kraton</p>
                    <p class="text-sm text-gray-600">kab bengkulu 93392</p>
                    <p class="text-sm text-gray-600">Indonesia</p>
                    <p class="text-sm text-gray-600">082334338392</p>

                    <!-- Alamat Penagihan
                                                                                                                                                                                                                                                                                                                                                        bumi balakosa
                                                                                                                                                                                                                                                                                                                                                        maospati, kraton
                                                                                                                                                                                                                                                                                                                                                        Kab. Kepahiang/Seberang Musi, Bengkulu, 63392
                                                                                                                                                                                                                                                                                                                                                        Indonesia
                                                                                                                                                                                                                                                                                                                                                        T: 082334337393 -->
                    <div class="text-gray-500 text-xs mt-5">
                        <a href="" class="underline hover:text-red-900">Ubah Alamat</a>&nbsp;
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
