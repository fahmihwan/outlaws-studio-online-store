@extends('toko.layout.main')

@section('container')
    <div class="w-full">
        <div class="w-full border-b-2 flex justify-between">
            <div class="flex items-center">
                <button class="p-4 hidden mr-2 btn-filter-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <span class="font-bold mr-3 p-4">
                    3 Hasil
                </span>

                <a href="" class="text-xs">Sepatu <span class="font-bold text-red-600 mr-5">x</span></a>
                <a href="" class="text-xs">Hodie <span class="font-bold text-red-600 mr-5">x</span></a>
                <a href="" class="text-xs">Kaos <span class="font-bold text-red-600 mr-5">x</span></a>
                <a href="" class="text-xs">Hapus Semua

                    </span></a>
            </div>
            <form class="flex items-center">
                <label for="countries" class="block mr-3  text-sm font-medium text-gray-900 dark:text-gray-400">Sort
                    By</label>
                <select id="countries"
                    class="border border-gray-200 focus:ring-gray-200    focus:border-gray-200 focus:border-0  text-gray-900 text-sm  block w-52 p-2.5 h-full">
                    <option selected="">Choose a country</option>
                    <option value="US">United States</option>
                    <option value="CA">Canada</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                </select>
            </form>
        </div>
        <!-- content -->
        <div class=" grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4   p-2 bg-gray-100">
            @foreach ($items as $item)
                <div>
                    <a href="/list-item/{{ $item->id }}/detail-item">
                        <img class="object-cover" src="{{ './storage/' . $item->gambar }}" alt="product image">
                    </a>
                    <div class="p-2 border flex justify-between bg-white ">
                        <div class="">{{ $item->nama }} <br>
                            <span class="text-gray-400">Rp {{ $item->harga }}</span>
                        </div>
                        <div class="text-right">
                            <span class="mb-3 text-gray-500">
                                {{ $item->kategori->nama }}
                            </span><br>
                            {{-- @if () --}}
                                
                            {{-- @endif --}}
                            <form method="POST" action="/list-item/wish_list/{{ $item->id }}">
                                @csrf
                                <button type="submit" class="mr-2"><i class="text-xl far fa-heart"></i></button>
                            </form>

                            {{-- /list-item/wish_list/{id}/destroy --}}
                            {{-- <i class="fa-solid fa-heart text-xl"></i> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
