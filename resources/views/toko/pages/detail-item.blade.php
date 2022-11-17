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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 ">Detail Item</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- resend_email --}}
    @include('toko.components.resend_email_confirmation')
@endsection

@section('container')
    <!-- full image  -->
    <div class="w-3/5 pt-5 pl-5 b">
        <h1 class="font-semibold pb-3">Detail Item</h1>
        <div class="border">
            <img class="mx-auto w-10/12" src="{{ asset('./storage/' . $item->gambar) }}" alt="">
        </div>

    </div>


    <!-- sidebar -->
    <aside class="w-2/5 border-r-2 px-20 pt-5 relative ">
        <!-- sticky top-0 -->

        <div class="sticky top-0 ">
            <!-- title & price -->
            <section class="mb-2">
                <p class="text-lg font-normal mb-2">{{ $item->nama }}</p>
                <p class="font-semibold">Rp. {{ number_format($item->harga, 0, '', '.') }}</p>
            </section>

            <!-- description -->
            <section class="mb-10">
                <article class="font-light text-sm h-40 overflow-hidden">
                    {{ $item->deskripsi }}
                </article>
            </section>

            <!-- form -->


            <section>
                <form action="/list-item/cart/{{ $item->id }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="" class="text-sm font-semibold mb-2 inline-block">Size <span
                                class="text-red-600">*</span></label>
                        <br>
                        <select required class="border-gray-300 h-14 block w-full" name="ukuran_id" id="">
                            <option value="">Choose an Option..</option>
                            @foreach ($select_ukurans as $select)
                                <option value="{{ $select->ukuran->id }}">{{ $select->ukuran->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-sm font-semibold mb-2 inline-block">Kuantitas</label>
                        <br>
                        <select class="border-gray-300 block w-36" name="qty" id="">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">8</option>
                            <option value="8">9</option>
                            <option value="9">10</option>
                        </select>
                    </div>

                    <div class="mb-4 flex">
                        <button type="submit"
                            class="border bg-black border-black  text-white hover:bg-white hover:text-black py-3 w-4/5">
                            Tambah ke Troli
                        </button>
                        <button
                            class="border bg-black border-l-white border-black text-white text-xl hover:text-2xl black w-1/5">
                            <i class="far fa-heart "></i>
                        </button>
                    </div>
                </form>


            </section>
        </div>
    </aside>
@endsection
