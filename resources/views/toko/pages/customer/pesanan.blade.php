@extends('toko.layout.main')

@section('container')
    <!-- conetent -->
    <div class=" md:flex w-full mt-10">
        <!-- sidebar -->
        @include('toko.components.sidebar-account')

        <div class=" md:w-full">
            <div class=" m-2 py-4 px-10">
                <h1 class="font-bold text-2xl mb-7">Pesanan</h1>

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


            </div>
        </div>
    </div>
@endsection
