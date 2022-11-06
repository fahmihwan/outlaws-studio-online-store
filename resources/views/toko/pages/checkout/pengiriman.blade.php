@extends('toko.layout.main_checkout')

@section('container-checkout')
    <div class="w-full md:w-2/3 pr-0 md:pr-8 mb-5 md:mb-0  ">
        <div class="border h-full">

            {{-- tabs --}}
            <div class=" md:flex hidden ">
                <div class=" border-t-2 p-3  border-emerald-500 w-1/2 inline-block text-center">
                    <span
                        class="bg-emerald-500 inline-block  rounded-full w-6 text-center  text-white mr-1">1</span>Pengiriman
                </div>
                <div class=" border-t-2 p-3 bg-gray-100  w-1/2 inline-block text-center">
                    <span class="bg-gray-700 inline-block  rounded-full w-6 text-center text-white mr-1">2
                    </span>Pembayaran
                </div>
            </div>



            <div class="pt-10 border-b-2 border-gray-200 pb-3  mx-5 ">
                ALAMAT PENGIRIMAN
            </div>
            <div class="flex flex-wrap " id="radio-group">
                {{-- @foreach ($alamats as $alamat)
                    <section class="cek-alamat text-sm border-2 p-3 border-black flex w-full md:w-1/3 m-3 cursor-pointer">
                        <article class="w-5/6">
                            <ul>
                                <li class="mb-1">
                                    {{ $alamat->nama_depan }} {{ $alamat->nama_belakang }}
                                </li>
                                <li class="mb-1">
                                    {{ $alamat->alamat }}
                                </li>
                                <li class="mb-1">
                                    {{ $alamat->kota }}/{{ $alamat->kecamatan }}, {{ $alamat->provinsi }}
                                    {{ $alamat->kode_pos }}
                                </li>
                                <li class="mb-1">
                                    {{ $alamat->telp }}
                                </li>
                            </ul>
                        </article>
                        <div class=" w-1/6 text-center">
                            <input class="radio-box-alamat" type="radio" name="alamat" value="1">
                        </div>
                    </section>
                @endforeach --}}


                {{-- <label class="cek-alamat text-sm border-2 p-3 border-black flex w-full md:w-1/3 m-3 cursor-pointer"
                    for="alamat-1">
                    <div class="w/5/6">
                        <ul>
                            <li class="mb-1">
                                bumi balakosa
                            </li>
                            <li class="mb-1">
                                maospati, kraton
                            </li>
                            <li class="mb-1">
                                Kab. Kepahiang/Seberang Musi, Bengkulu 63392
                            </li>
                            <li class="mb-1">
                                082334337393
                            </li>
                        </ul>
                    </div>

                </label>
                <div class=" w-1/6 text-center">
                    <input id="alamat-1" class="radio-box-alamat" type="radio" name="alamat" value="1">
                </div> --}}


                <section class="cek-alamat text-sm  w-full md:w-1/3 m-3 cursor-pointer relative">
                    <label for="alamat-1" class="label-alamat w-full border-2 p-3 flex ">
                        <ul>
                            <li class="mb-1">
                                bumi balakosa
                            </li>
                            <li class="mb-1">
                                maospati, kraton
                            </li>
                            <li class="mb-1">
                                Kab. Kepahiang/Seberang Musi, Bengkulu 63392
                            </li>
                            <li class="mb-1">
                                082334337393
                            </li>
                        </ul>
                    </label>
                    {{-- <i class="fa-solid fa-check absolute top-0 right-5 text-2xl"></i> --}}
                    <input id="alamat-1" class="radio-alamat absolute top-0 right-0" type="radio" name="alamat"
                        value="1">
                </section>

                <section class="cek-alamat text-sm  w-full md:w-1/3 m-3 cursor-pointer relative">
                    <label for="alamat-2" class="label-alamat w-full border-2 p-3 flex ">
                        <ul>
                            <li class="mb-1">
                                bumi balakosa
                            </li>
                            <li class="mb-1">
                                maospati, kraton
                            </li>
                            <li class="mb-1">
                                Kab. Kepahiang/Seberang Musi, Bengkulu 63392
                            </li>
                            <li class="mb-1">
                                082334337393
                            </li>
                        </ul>
                    </label>
                    {{-- <i class="fa-solid fa-check absolute top-0 right-5 text-2xl"></i> --}}
                    <input id="alamat-2" class="radio-alamat absolute top-0 right-0" type="radio" name="alamat"
                        value="2">
                </section>





            </div>
            <!-- Modal toggle -->
            <button class="block px-4  underline focus:ring-0" type="button" data-modal-toggle="authentication-modal">
                Tambah alamat baru
            </button>
        </div>
    </div>


    <div class="border w-full md:w-1/3">
        <div class="w-[90%] pt-5 mx-auto font-bold">
            Ringkasan Berbelanja
        </div>
        <div class="w-90% p-3  ">
            @foreach ($items as $item)
                <div class="flex border-t-2 pt-2 pb-7">
                    <img class="w-24 mr-3" src="{{ asset('./storage/' . $item->item->gambar) }}" alt="">
                    <article>
                        {{ $item->item->nama }}<br>
                        Jumlah : {{ $item->qty }} <br>
                        Size : {{ $item->ukuran->nama }} <br>
                    </article>
                </div>
            @endforeach

            {{-- <div class="flex border-t-2 pt-2 pb-7">
                <img class="w-24" src="/src/img-outlaws/2.jpg" alt="">
                <article>
                    Converse tes tes tes <br>
                    Jumlah : 1 <br>
                    Size : 2 <br>
                </article>
            </div> --}}
        </div>
        <div class="flex justify-between p-3">
            <span class="font-light text-sm">Sub Total</span>
            <span>Rp. 2.399.000</span>
        </div>
        <div class="border flex justify-between p-3 ">
            <span class="font-light text-sm">Total</span>
            <span class="font-extrabold">Rp. 2.399.000</span>
        </div>
    </div>

    <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
        <div class="relative  w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white  shadow ">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm  ml-auto inline-flex items-center  "
                    data-modal-toggle="authentication-modal">
                    <i class="fa-solid fa-xmark"></i>
                    <span class="sr-only">Close modal</span>
                </button>


                <div class="py-6  lg:px-4 ">
                    <h3 class="mb-4 text-2xl font-semibold text-center border-b pb-5  font-00 ">
                        Alamat pengiriman
                    </h3>
                    <form class="m-0" action="/alamat" method="POST">
                        @csrf
                        <div class="overflow-scroll h-96 pl-5">
                            <div class=" w-full mb-2 md:mb-8">
                                <label for="nama_depan" class="block mb-1 text-xs font-normal text-gray-900 ">Nama Depan
                                    <span class="text-red-700">*</span></label>
                                <input type="text" name="nama_depan" id="nama_depan"
                                    class=" w-3/4 border border-gray-400   text-gray-900 text-sm  h-8"
                                    placeholder="Nama Depan" required="">
                            </div>
                            <div class=" w-full mb-2 md:mb-8">
                                <label for="nama_belakang" class="block mb-1 text-xs font-normal text-gray-900 ">Nama
                                    Belakang
                                    <span class="text-red-700">*</span></label>
                                <input type="text" name="nama_belakang" id="nama_belakang"
                                    class=" w-3/4 border border-gray-400   text-gray-900 text-sm  h-8"
                                    placeholder="Nama Belakang" required="">
                            </div>
                            <div class=" w-full mb-2 md:mb-8">
                                <label for="alamat" class="block mb-1 text-xs font-normal text-gray-900 ">Alamat
                                    <span class="text-red-700">*</span></label>
                                <input type="text" name="alamat" id="alamat"
                                    class=" w-3/4 border border-gray-400   text-gray-900 text-sm  h-8" placeholder="Alamat"
                                    required="">
                            </div>
                            <div class=" w-full  mb-2 md:mb-8">
                                <label for="" class="block mb-1 text-xs font-normal text-gray-900 ">Negara
                                    <span class="text-red-700">*</span></label>
                                <input type="text" name="" id=""
                                    class=" w-3/4 border border-gray-400  text-gray-900 text-sm  h-8" placeholder="negara"
                                    value="Indonesia" readonly required="">
                            </div>
                            <div class=" w-full mb-2 md:mb-8">
                                <label for="provinsi" class="block mb-1 text-xs font-normal text-gray-900 ">Provinsi
                                    <span class="text-red-700">*</span></label>
                                <select name="provinsi" id="provinsi"
                                    class=" w-3/4 py-0 border border-gray-400  text-gray-900 text-sm  h-8" required>
                                    <option value="">Pilih wilayah atau provinsi</option>
                                </select>
                            </div>
                            <div class=" w-full mb-2 md:mb-8">
                                <label for="kota" class="block mb-1 text-xs font-normal text-gray-900 ">Kota
                                    <span class="text-red-700">*</span></label>
                                <select name="kota" id="kota"
                                    class=" w-3/4 py-0 border border-gray-400  text-gray-900 text-sm  h-8" required>

                                </select>
                            </div>
                            <div class=" w-full mb-2 md:mb-8">
                                <label for="kecamatan" class="block mb-1 text-xs font-normal text-gray-900 ">Kecamatan
                                    <span class="text-red-700">*</span></label>
                                <select name="kecamatan" id="kecamatan"
                                    class=" w-3/4 py-0 border border-gray-400  text-gray-900 text-sm  h-8" required>
                                </select>
                            </div>
                            <div class=" w-full mb-2 md:mb-8">
                                <label for="kode_pos" class="block mb-1 text-xs font-normal text-gray-900 ">Kode Pos
                                    <span class="text-red-700">*</span></label>
                                <input type="text" name="kode_pos" id="kode_pos"
                                    class=" w-3/4 border border-gray-400   text-gray-900 text-sm  h-8"
                                    placeholder="Kode pos" required>
                            </div>
                            <div class=" w-full mb-2 md:mb-8">
                                <label for="nama_depan" class="block mb-1 text-xs font-normal text-gray-900 ">Nomor
                                    Telepon
                                    <span class="text-red-700">*</span></label>
                                <div class="relative">
                                    <div
                                        class="flex absolute text-sm inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        62
                                    </div>
                                    <input type="number" name="telp" id="telp"
                                        class="w-3/4 border border-gray-400 pl-9 focus:ring-0  text-gray-900 text-sm h-8 "
                                        placeholder="">
                                </div>
                            </div>
                        </div>



                        {{-- api --}}


                        <div class="px-5 flex">
                            <button data-modal-toggle="authentication-modal"
                                class="w-full text-white mt-7 mr-2 bg-black border border-black hover:bg-white hover:text-black duration-300 focus:ring-0 focus:outline-none  font-medium  text-sm px-5 py-2.5 text-center ">
                                Batal
                            </button>
                            <button type="submit"
                                class="w-full text-white mt-7 ml-2 bg-black border border-black hover:bg-white hover:text-black duration-300 focus:ring-0 focus:outline-none  font-medium  text-sm px-5 py-2.5 text-center ">Tambahkan</button>
                        </div>
                </div>
                </form>


            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script id="midtrans-script" type="text/javascript" src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        data-environment="sandbox" data-client-key="SB-Mid-client-8TLIpQcwFzXQGo9i"></script>
    <script>

        
        $(document).ready(function() {























            const active = "border-black text-black";
            const nonActive = "border-gray-300 text-gray-400";

            $('.radio-alamat').each(function() {
                if ($('.radio-alamat').is(':checked')) {
                    console.log($(this))
                    $(this)
                } else {
                    console.log($(this))
                }
            })













            $.ajax({
                url: 'http://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
                type: 'GET',
                success: function(res) {
                    let prov = '';
                    res.forEach(data => {
                        prov +=
                            `<option value="${data.name}" data-id="${data.id}">${data.name}</option>`;
                    });
                    $('#provinsi').append(prov)
                }
            });

            $('#provinsi').change(function() {
                let id = $(this).find(':selected').attr('data-id')
                $.ajax({
                    url: `http://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`,
                    type: 'GET',
                    success: function(res) {
                        let kota = ''
                        $('#kota').html('')
                        $('#kota').append(
                            `<option value="" selected> Pilih kota </option>`
                        )
                        res.forEach(data => {
                            kota +=
                                `<option value="${data.name}" data-id="${data.id}">${data.name}</option>`;
                        });
                        $('#kota').append(kota)
                    }
                })
            })

            $('#kota').change(function() {
                let id = $(this).find(':selected').attr('data-id')
                $.ajax({
                    url: `http://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`,
                    type: 'GET',
                    success: function(res) {
                        $('#kecamatan').html('')
                        $('#kecamatan').append(
                            `<option value="" selected> Pilih kecamatan </option>`
                        )
                        let kecamatan = '';
                        res.forEach(data => {
                            kecamatan +=
                                `<option value="${data.name}" data-id="${data.id}">${data.name}</option>`;
                        });
                        $('#kecamatan').append(kecamatan)
                    }
                })
            })




        })
    </script>
@endsection
