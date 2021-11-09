<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\MemberOTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;

class OtpController extends Controller
{

    public function index()
    {
        $data['email'] = session('email');
        return view('auth.otp', $data);
    }

    public function request(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required',
        ]);

       $user = $this->getUser($request->email_or_phone);
       if($user==null)
           return back()->with('error','Data anggota tidak ditemukan.');

        $email = $user->email;
        $username = $this->obfuscate_email($email);

        $otp = rand(1111,9999);

        $reset = DB::table('password_resets')->where('email',$email)->first();
        if($reset!=null){
            DB::table('password_resets')
            ->where('email',$email)
            ->update([
                'token'=>Hash::make($otp),
                'created_at'=>Carbon::now(),
            ]);
        }else{
            $id = DB::table('password_resets')->insert([
                'email'=>$email,
                'token'=>Hash::make($otp),
                'created_at'=>Carbon::now(),
            ]);
        }

        $user->notify(new MemberOTP($otp));

        return back()->with(['status'=>'Kode OTP telah dikirim ke alamat email '.$username,'email'=>$email])->withInput();
    }

    private function obfuscate_email($email)
    {
        $em   = explode("@",$email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        $len  = floor(strlen($name)/2);

        return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
    }

    private function getUser($credential)
    {
        if (filter_var($credential, FILTER_VALIDATE_EMAIL))
            return User::where('email',$credential)->first();
        else{
            $phone = $this->parse($credential);
            $member = Member::where('phone',$phone)->first();
            if($member->user)
                return $member->user;
        }

        return null;
    }

    private function parse($value)
    {
        $phone = $value;
        $prefix = substr($phone,0,1);
        if ($prefix=='+')
            $phone = substr($phone,1,strlen($phone));
            
        $prefix = substr($phone,0,1);
        if ($prefix=='0')
            $phone = "62".substr($phone,1,strlen($phone));

        return $phone;
    }

    public function check(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required',
            'password'=>'required|min:4',
        ]);

        $user = $this->getUser($request->email_or_phone);
        if($user==null)
            return back()->with('error','Data anggota tidak ditemukan.');

        $check = DB::table('password_resets')->where('email',$user->email)->first();

        if($check && Hash::check($request->password,$check->token)){
            DB::table('password_resets')
            ->where('email',$check->email)
            ->delete();

            Auth::login($user);
            return redirect()->route('member.dashboard');
        }

        return back()->with(['error'=>'Kode OTP/Email tidak sesuai','email'=>$request->email_or_phone]);
        
    }

}