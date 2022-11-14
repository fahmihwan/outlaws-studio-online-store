@extends('cms.layouts.main')


@section('container')
    <div class="w-full px-2 ">
        <nav class="flex justify-between mb-4 p-2 bg-white shadow-md text-black rounded-md" aria-label="Breadcrumb ">
            <div class="font-bold text-2xl text-gray-700">
                Detail Customer
            </div>
            <div>
                <ol class="inline-flex items-center space-x-1 md:space-x-3  ">
                    <li class="inline-flex items-center">
                        <a href="/admin/list-customer"
                            class="inline-flex items-center text-sm font-medium  hover:text-gray-900">
                            List Customer
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-400"></i>
                            <a href="#" class="ml-1 text-sm font-medium hover:text-gray-900 md:ml-2 ">Detail
                                Customer</a>
                        </div>
                    </li>
                </ol>
            </div>
        </nav>



        <section class="flex justify-between mb-2">
            <div>
            </div>
            <a href="/admin/list-customer"
                class="bg-purple-600 hover:bg-white hover:text-black border hover:duration-200 hover:border-purple-600 text-white p-2 rounded">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </section>


        <div class="flex flex-col-reverse md:flex-row">
            <div class="w-full md:w-4/6 bg-white rounded mt-3 mb-6 md:mb-0">
                <div class="overflow-x-auto border-2 border-purple-700  shadow-md rounded ">
                    <div class="px-2 bg-purple-700  text-white">
                        Informasi Item
                    </div>
                    <table class="w-full text-sm text-left text-gray-500 bg-gray-100 ">
                        <tr class="border-b">
                            <th scope="col" class=" py-2 px-6 flex items-start">
                                Nama
                            </th>
                            <td class="py-2 px-6 bg-white">
                                {{ $user->credential->nama_depan }} {{ $user->credential->nama_belakang }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th scope="col" class=" py-2 px-6 flex items-start">
                                Email
                            </th>
                            <td class="py-2 px-6 bg-white">
                                {{ $user->email }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th scope="col" class=" py-2 px-6 flex items-start">
                                Tanggal Lahir
                            </th>
                            <td class="py-2 px-6 bg-white">
                                {{ $user->credential->tanggal_lahir }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th scope="col" class=" py-2 px-6 flex items-start">
                                Telp
                            </th>
                            <td class="py-2 px-6 bg-white">
                                {{ $user->credential->telp }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th scope="col" class=" py-2 px-6 flex items-start">
                                Status
                            </th>
                            <td class="py-2 px-6 bg-white">
                                {{ $user->status }}
                            </td>
                        </tr>



                    </table>
                </div>

            </div>


        </div>

    </div>
@endsection
