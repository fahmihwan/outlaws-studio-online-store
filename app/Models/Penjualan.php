<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function alamat()
    {
        return $this->belongsTo(Alamat::class)->withTrashed();
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kurir()
    {
        return $this->belongsTo(Kurir::class);
    }

    public function detail_penjualans()
    {
        return $this->hasMany(Detail_penjualan::class);
    }

    // public function scopeFilter($query, array $filters)
    // {
    //     return $query->with([
    //         'buku:id,judul',
    //         'anggota:id,nama,role_id',
    //         'anggota.role:id,nama',
    //         'petugas:id,credential_id',
    //         'petugas.credential:id,nama',
    //     ])->whereDate('tanggal_pinjam', '>=', $filters['start_date'])->whereDate('tanggal_pinjam', '<=', $filters['end_date']);
    // }
}
