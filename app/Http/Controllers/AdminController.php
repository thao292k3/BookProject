<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

    public function login()
    {
        return view('admin.login'); // Trả về view form đăng nhập
    }

    public function loginPost(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // Kiểm tra xem input có phải là email hay username
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        // Tìm người dùng theo email hoặc username
        $user = User::where($loginField, $request->login)->first();

        // Kiểm tra xem người dùng có tồn tại và mật khẩu có đúng không
        if ($user && $user->password === md5($request->password)) {
            // Đăng nhập thành công
            Auth::login($user);

            // Kiểm tra vai trò và chuyển hướng
            if ($user->role === 'admin') {
                return redirect()->route('admin.index')->with('success', 'Đăng nhập thành công với vai trò admin.');
            } else {
                return redirect()->route('site.index')->with('success', 'Đăng nhập thành công với vai trò người dùng.');
            }
        }

        // Trả về lỗi nếu đăng nhập thất bại
        return back()->withErrors([
            'login' => 'Email hoặc tên đăng nhập hoặc mật khẩu không đúng.',
        ])->withInput();
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Bạn đã đăng xuất.');
    }
}
