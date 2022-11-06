<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ListCustomerController extends Controller
{
    public function index()
    {
        $users = User::with('credential')->latest()->get();
        return view('cms.pages.list_customer.index', [
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $user = User::with('credential')->where('id', $id)->first();

        return view('cms.pages.list_customer.show', [
            'user' => $user
        ]);
    }
}
