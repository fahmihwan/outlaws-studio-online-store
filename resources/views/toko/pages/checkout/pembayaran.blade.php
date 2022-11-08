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
                    <span class="bg-emerald-500 inline-block  rounded-full w-6 text-center  text-white mr-1">1</span>
                    Pengiriman
                </a>
                <div class=" border-t-2 p-3  border-emerald-500 w-1/2 inline-block text-center">
                    <span class="bg-gray-700 inline-block  rounded-full w-6 text-center text-white mr-1">2
                    </span>
                    Pembayaran
                </div>

            </div>

            <div class=" h-[80%] flex justify-center items-center">
                <button id="pay-button" class="bg-black text-white p-2 w-40 text-center m-3">
                    Bayar Sekarang
                </button>

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
