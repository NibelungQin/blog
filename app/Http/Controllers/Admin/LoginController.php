<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use App\Http\Model\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';
class LoginController extends CommonController
{
    public function login()
    {
        if ($input=Input::all()){
            $code=new \Code();
            $getcode=$code->get();
            $users=User::all();
            if (strtoupper($input['code'])!=$getcode){
                return back()->with('msg','验证码错误!');
            }
            foreach ($users as $user){
                if ($user->name!=$input['username']||Crypt::decrypt($user->password)!=$input['password']){
                    return back()->with('msg','用户名或密码错误!');
                }
                session(['user'=>$user]);
                return redirect('admin/index');
            }
        }else{
            return view('admin.login');
        }
    }

    public function logout()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    public function code()
    {
        $code=new \Code();
        $code->make();
    }


}
