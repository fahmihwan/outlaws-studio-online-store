@extends('toko.layout.main')


@section('breadcrumb')
    <nav class="flex border  border-gray-200" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900  ">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                    <a href="/list-item" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2  ">List
                        Item</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center ">
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 ">Alamat</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('container')
    <!-- conetent -->
    <div class=" md:flex w-full mt-10">
        <!-- sidebar -->
        @include('toko.components.sidebar-account')

        {{-- informasi  --}}
        <div class=" md:w-full px-10 ">
            <div class="m-2 py-4 ">
                <h1 class="font-bold text-2xl mb-7">Alamat</h1>
                <h1 class="font-bold text-2xl pb-5 border-b-2">ALAMAT</h1>
            </div>

            <div class="flex">
                @foreach ($alamats as $almt)
                    <div class="mb-5 mr-5">
                        <h1 class="font-bold mb-4">Alamat Pengiriman</h1>
                        <p class="font-light text-sm pb-2">{{ $almt->nama_depan }} {{ $almt->nama_belakang }}</p>
                        <p class="font-light text-sm pb-2">{{ $almt->alamat }}</p>
                        <p class="font-light text-sm pb-2">{{ $almt->kota }}, {{ $almt->provinsi }}, {{ $almt->kode_pos }}
                        </p>
                        <p class="font-light text-sm pb-2">{{ $almt->telp }}</p>
                        <a href="" class="underline text-xs hover:text-red-500">Ubah Alamat Pengiriman</a>
                    </div>
                @endforeach
            </div>


            <div class="">
                <h1 class="font-bold text-2xl pb-5 border-b-2 mb-10">Alamat Tambahan </h1>
                <div class="">
                    <table class="w-full text-left text-gray-500  text-xs">
                        <thead class="text-xs text-gray-900  ">
                            <tr class="border-b">
                                <th scope="col" class="py-2 px-0">
                                    Nama Depan
                                </th>
                                <th scope="col" class="py-2 px-0">
                                    Nama Belakang
                                </th>
                                <th scope="col" class="py-2 px-0">
                                    Alamat
                                </th>
                                <th scope="col" class="py-2 px-0">
                                    Provinsi
                                </th>
                                <th scope="col" class="py-2 px-0">
                                    Kota
                                </th>
                                <th scope="col" class="py-2 px-0">
                                    Kode Pos
                                </th>
                                <th scope="col" class="py-2 px-0">
                                    Nomor Telp
                                </th>
                                <th scope="col" class="py-2 px-0">
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($alamats as $alamat)
                                <tr class="border-b ">
                                    <th scope="row" class="py-2 px-0 font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $alamat->nama_depan }}
                                    </th>
                                    <td class="py-2 px-0">
                                        {{ $alamat->nama_belakang }}
                                    </td>
                                    <td class="py-2 px-0">
                                        {{ $alamat->alamat }}
                                    </td>
                                    <td class="py-2 px-0">
                                        {{ $alamat->provinsi }}
                                    </td>
                                    <td class="py-2 px-0">
                                        {{ $alamat->kota }}
                                    </td>
                                    <td class="py-2 px-0">
                                        {{ $alamat->kode_pos }}
                                    </td>
                                    <td class="py-2 px-0">
                                        {{ $alamat->telp }}
                                    </td>
                                    <td class="py-2 px-0 flex ">
                                        <a class="text-red-500" href="">Ubah</a> &nbsp;| &nbsp;
                                        <form action="">
                                            <button class="text-red-500">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                    <div class="float-right mt-5 mb-5 text-sm">
                        <label for="">Show</label>
                        <select name="" id="" class="border border-gray-300 rounded-sm w-14 p-2 text-sm">
                            <option value="">10</option>
                            <option value="">20</option>
                            <option value="">50</option>
                        </select>
                        <label for="">Per Page</label>
                    </div>

                </div>
                <a href=""
                    class="mt-20 inline-block border border-black p-2 w-40 text-center bg-black text-white hover:bg-white hover:text-black">Tambah
                    Alamat</a>


                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>

        </div>
    </div>
@endsection
