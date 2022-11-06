@extends('toko.layout.main')

@section('container')
    <!-- conetent -->
    <div class=" md:flex w-full pt-10 bg-gray-50">
        <!-- sidebar -->
        @include('toko.components.sidebar-account')

        <div class=" md:w-full">
            <div class=" m-2 py-4 px-10">
                <h1 class="font-bold text-2xl mb-7">Wish List</h1>

                <p class="text-sm">7 item(s)</p>
                <div class=" grid grid-cols-4 gap-8">

                    @foreach ($items as $item)
                        <div class="group hover:bg-white hover:border border-gray-600   h-full">
                            <img src="{{ asset('./storage/' . $item->item->gambar) }}" alt="">
                            <div class="px-2">
                                <h1 class="font-light">{{ $item->item->nama }}</h1>
                                <p class="font-light">Rp. {{ number_format($item->item->harga, 0, '', '.') }}</p>
                            </div>
                            <div class=" text-center">
                                {{-- <form action="/list-item/wish_list/{id}"> --}}
                                <a href="/list-item/{{ $item->item_id }}/detail-item" style="overflow: hidden"
                                    class="bg-black invisible group-hover:visible inline-block  text-center  mb-2 mt-3 text-white p-2 text-sm">
                                    Tambah Ke Troli
                                </a>
                                {{-- </form> --}}

                                {{-- <a href="overflow-hidden group-hover:overflow-auto"></a> --}}
                            </div>

                        </div>
                    @endforeach




                </div>
            </div>
        </div>
    </div>
@endsection
