<?php

namespace App\Http\Controllers;

use App\Models\MUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $userId = data_get($request, 'user_id', '');
        if (!empty($userId)) {
            $user = MUser::where('user_id', $userId)->first();
            if ($user) {
                Auth::login($user, false);
                return redirect()->intended(RouteServiceProvider::HOME);
            }
            $msg = __('messages.MSG_ERR_013', ['target'=>__('attributes.m_user.user_id')]);
        } else {
            $msg = __('Forbidden');
        }
        Auth::logout();
        return view('errors.msg-only', ['message' => $msg]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return view('errors.msg-only', ['message' => __('messages.MSG_INF_009')]);
    }
}
