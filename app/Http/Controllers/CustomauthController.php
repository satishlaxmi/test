<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Chat;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;

use Hash;
use Session;

class CustomauthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function register_view(){
        return view('auth.register');
    }

    public function logout(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('login')->with('logout','you are logged out');
}

    public function getuser(Request $request)
    {
        $login = $request->input('email');
        $user = User::where('email', $login)->orWhere('name', $login)->first();
        $user = User::where('email', $login)->orWhere('name', $login)->first();
        $userEverified = $user->email_verified_at;
        if(is_null($userEverified)){
            return redirect("login")->with('notverified', 'first verfy your eamil');
        }else{
            if (!$user) {
                return redirect()->back()->withErrors(['email' => 'Invalid login credentials']);
            }
            $request->validate([
                'password' => 'required|min:6',
            ]);
            if (Auth::attempt(['email' => $user->email, 'password' => $request->password]) ||
                Auth::attempt(['name' => $user->name, 'password' => $request->password])) {
                Auth::loginUsingId($user->id);
                return redirect('/');
            } else {
                return redirect()->back()->withErrors(['password' => 'Invalid login credentials']);
            }
        }

        
    }
   
    public function adduser(Request $request){
        $data = $request->all();
        $validatedData = $request->validate([
            'name' => 'required',
            'password' => 'required|same:confirm_password',
            'email' => 'required|email|unique:users',
        ]);
        $createUser = User::savedata($data);
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $createUser->id,
            'token' => $token,
        ]);

        Mail::send('emails.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Email Verification Mail');
        });

        return redirect("login")->with('success', 'you are registerd successfuly and an email has sedn
        to the your email please check your email address and verify it ');

    }

    public function sendTokenAgain($id)
    {
        $user_id = decrypt($id);
        $verifyUser = UserVerify::where('user_id', $user_id)->first();
        $User = User::where('id', $user_id)->first();
        $getemail = $User->email;
        if ($verifyUser) {
            $hello = "hello";
            $verifyUser->token = "hello";
            $verifyUser->save();
            Mail::send('emails.emailReVerificationEmail', ['token' => $hello], function ($message) use ($getemail) {
                $message->to($getemail);
                $message->subject('Email  re Verification Mail');
            });
            return redirect("login")->with('success', 'you are registerd successfuly and an email has send
            to the your email please check your email address and verify it ');
        } else {
            echo "no user found";
        }
    }

    public function verifyAccount($token){
        $verifyUser = UserVerify::where('token', $token)->first();
        $user_id = $verifyUser->user_id;
        $message = 'Sorry your email cannot be identified.';
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;

            if (!$user->email_verified_at) {
                $created_at = $verifyUser->updated_at;
                $diff = now()->diffInMinutes(Carbon::parse($created_at));
                echo $diff;
                if ($diff > 15) {
                    $user_id = encrypt($user_id);
                    $messageWithLink = "Click the link to view your profile: ";
                    $link = route('sendTokenAgain', $user_id);
                    $message = $messageWithLink . '<a href="' . $link . '">View Profile</a>';
                } else {
                    $verifyUser->user->email_verified_at = date("Y-m-d h:i:s");
                    $verifyUser->user->save();
                    $message = "Your e-mail is verified. You can now login.";
                }

            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
        return redirect()->route('login')->with('message', $message);
    }


     public function chat(){
        $user =  User::all();
        $chat_reciver = Chat::where('reciver_id',Auth::user()->id)->where('confirmed',0)->get();
        $chat_sender =  Chat::where('sender_id',Auth::user()->id)->where('confirmed',0)->get();

        $join = DB::table('users')
        ->join('chat', 'users.id', '=', 'chat.sender_id')
        ->select('users.*', 'chat.*')
        ->where(function ($query) {
        $query->where('chat.sender_id', Auth::user()->id)
        ->orWhere('chat.reciver_id', Auth::user()->id);
        })
        ->where('chat.confirmed', '=', 1)
        ->get();


        return view('auth.user.chat',compact('user','chat_reciver','chat_sender','join'));

    } 
 
  
     
   

}













    
      
    




