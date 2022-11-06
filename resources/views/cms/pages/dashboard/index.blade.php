@extends('cms.layouts.main')


@section('container')
    <div class="w-full  ">
        <nav class="flex justify-between mb-4 p-2 bg-white shadow-md text-black rounded-md" aria-label="Breadcrumb ">
            <div class="font-bold text-2xl text-gray-700">
                Dashboard
            </div>
            <div>
                <ol class="inline-flex items-center space-x-1 md:space-x-3  ">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-sm font-medium  hover:text-gray-900">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-400"></i>
                            <a href="#" class="ml-1 text-sm font-medium hover:text-gray-900 md:ml-2 ">Projects</a>
                        </div>
                    </li>
                </ol>
            </div>
        </nav>

        <div class="w-full shadow-md bg-white rounded-md p-3 ">

            Dashboard <br>
            Dashboard <br>
            Dashboard <br>
            Dashboard <br>
            Dashboard <br>
            Dashboard

        </div>
    </div>
@endsection
