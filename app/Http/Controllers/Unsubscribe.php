<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class Unsubscribe extends Controller
{
    public function __invoke($token)
    {
        $id = Crypt::decryptString($token);
        $user = User::findOrFail($id);
        $user->is_notify = false;
        $user->save();

        return view('unsubsribe');
    }
}
