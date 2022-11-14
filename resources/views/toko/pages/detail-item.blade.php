@extends('toko.layout.main')

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
