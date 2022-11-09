@extends('toko.layout.main_checkout')

@section('head')
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-8TLIpQcwFzXQGo9i"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
@endsection

@section('container-checkout')
    <div class="w-full md:w-2/3 pr-0 md:pr-8 mb-5 md:mb-0  ">
        <div class="border h-full">

            {{-- tabs --}}
            <div class=" md:flex hidden ">
                <a href="/checkout/pengiriman" class=" border-t-2 p-3 block bg-gray-100  w-1/2 text-center">
                    <span class="bg-gray-700 inline-block  rounded-full w-6 text-center  text-white mr-1">1</span>
                    Pengiriman
                </a>
                <div class=" border-t-2 p-3  border-emerald-500 w-1/2 inline-block text-center">
                    <span class="inline-block  bg-emerald-500 rounded-full w-6 text-center text-white mr-1">2
                    </span>
                    Pembayaran
                </div>
            </div>

            <div class="p-5 h-72">
                <div class=" relative mb-3">
                    <label for="bca" class="border border-gray-300 w-full flex h-14 items-center justify-between">
                        <p class="ml-12 font-semibold"> BCA Virtual Account</p>
                        <img src="{{ asset('./logo-bank/bca.png') }}" alt="" class="w-20 h-6 mr-3">
                    </label>
                    <input id="bca" type="radio" name="bank" class="absolute top-5 left-5">
                </div>
                <div class=" relative mb-3">
                    <label for="bni" class="border border-gray-300 w-full flex h-14 items-center justify-between">
                        <p class="ml-12 font-semibold"> BNI Virtual Account</p>
                        <img src="{{ asset('./logo-bank/bni.png') }}" alt="" class="w-20 h-6 mr-3">
                    </label>
                    <input id="bni" type="radio" name="bank" class="absolute top-5 left-5">
                </div>
                <div class=" relative mb-3">
                    <label for="bri" class="border border-gray-300 w-full flex h-14 items-center justify-between">
                        <p class="ml-12 font-semibold"> BRI Virtual Account</p>
                        <img src="{{ asset('./logo-bank/bri.png') }}" alt="" class="w-20 h-6 mr-3">
                    </label>
                    <input id="bri" type="radio" name="bank" class="absolute top-5 left-5">
                </div>

            </div>
            <div class="flex justify-end items-end p-5">
                <button
                    class="border-black border p-2 w-52 bg-black text-white hover:bg-white hover:text-black duration-300">Buat
                    Pesanan</button>
            </div>

        </div>
    </div>


    @include('toko.components.sidebarCheckout')
@endsection

@section('script')
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snap_token }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("payment success!");
                    console.log(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
@endsection
