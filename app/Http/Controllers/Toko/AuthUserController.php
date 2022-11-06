<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Credential;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthUserController extends Controller
{
    public function register()
    {
        return view('toko.pages.auth.register');
    }

    public function store_account(Request $request)
    {
        $validated = $request->validate([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'tanggal' => 'required|numeric',
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'telp' => 'required|numeric',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        if ($validated['password'] != $validated['confirm_password']) {
            return redirect()->back()->withErrors('Password and Confirm Password must be equal');
        }
        $validated['password'] = Hash::make($validated['password']);

        try {
            DB::beginTransaction();
            $credential_id = Credential::create([
                'nama_depan' => $validated['nama_depan'],
                'nama_belakang' => $validated['nama_belakang'],
                'tanggal_lahir' => $validated['tahun'] . '-' . $validated['bulan'] . '-' . $validated['tanggal'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'telp' => '+62' . $validated['telp']
            ])->id;

            User::create([
                'email' => $validated['email'],
                'password' => $validated['password'],
                'credential_id' => $credential_id,
                'status' => 'active'
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect('list-item');
    }

    public function authenticate(Request $request)
    {
        $validated =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return redirect('/customer/account/login')->withErrors('The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.');
    }

    public function register_or_login()
    {
        return view('toko.pages.auth.register_or_login');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/list-item');
    }
}
