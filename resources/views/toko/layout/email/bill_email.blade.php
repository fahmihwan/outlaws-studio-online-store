<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .paragraf {
            text-align: center;
            margin-top: 15px
        }
    </style>
</head>

<body style="">
    <div style="border: 1px solid black; width: 500px; margin: 20px auto; padding: 10px;">
        <div style="text-align: center">
            <p>Hi fahmi ihwan</p>
            <p style="font-size: 17px; font-weight: bold">TERIMA KASIH SUDAH MEMESAN DI CONVERSE</p>
            Pesanan sedang <span style="font-weight: bold">Menunggu Pembayaran</span>
        </div>

        <div class="paragraf">
            <p style="font-weight: bold">Berikut kode pembayaran rekening virtual:</p>
            <p style="font-weight: bold; font-size: 23px;">{{ $data['va_numbers'][0]['va_number'] }}
            </p>
            <p>Kami akan memproses pesanan setelah kami menerima pembayaran Anda</p>
        </div>
        <div class="paragraf">
            <p style="font-weight: bold; font-size: 17px;">METODE PENGIRIMAN</p>
            <p>Regular - JNE Regular</p>
        </div>
        <div class="paragraf">
            <p style="font-weight: bold; font-size: 17px;">BATAS AKHIR PEMBAYARAN</p>
            <p>11 November 2022 01.32.02 WIB</p>
        </div>
        <div class="paragraf">
            <p style="font-weight: bold; font-size: 17px;">METODE PEMBAYARAN</p>
            <p>{{ $data['va_numbers'][0]['bank'] }}</p>
        </div>
        <div class="paragraf">
            <p style="font-size: 12px">Jika Anda memiliki pertanyaan tentang pesanan Anda, silakan email kami di
                connect@converse.id atau
                hubungi
                dengan kami di 081575111117. Jam operasional kami adalah 08.00 - 21.00 WIB.</p>
        </div>
        <div class="paragraf">
            <p style="font-size: 20px">Pesanan dengan nomor order <span
                    style="font-weight: bold">#{{ $data['order_id'] }}</span>
            </p>
            <p style="color:gray">Dilakukan pada {{ $data['transaction_time'] }}</p>
            <hr style="margin-top: 10px">
        </div>
        <div style="margin-top: 10px;">
            <p style="font-size: 20px">NFO PENGIRIMAN:</p>
            <div>
                fahmi ihwan <br>
                magetan <br>
                Amlapura/Amlapura, Bali, 63392 <br>
            </div>

            <hr style="margin-top: 10px">
        </div>
        <div style="margin-top: 10px;">
            CONVERSE CHUCK 70 TRIPPY HEEL MEN'S SNEAKERS - BLACK
            <hr style="margin-top: 10px">
        </div>

    </div>
</body>

</html>
