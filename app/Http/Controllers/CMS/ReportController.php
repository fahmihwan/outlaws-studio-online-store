<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $items = Penjualan::with(['pembayaran:id,transaction_status', 'user:id,email'])->get();

        return view('cms.pages.report.index', [
            'items' => $items
        ]);
    }
}
