<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account.index');
    }

    public function update(UpdateAccountRequest $request)
    {
        $update['name'] = $request->name;
        $update['email'] = $request->email;
        if ($request->password) {
            $update['password'] = Hash::make($request->password);
        }
        
        $request->user()->update($update);
        
        return redirect()->route('account.index')->with('info', 'Data akun berhasil diubah.');
    }
}
