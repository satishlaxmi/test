<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;
use App\Models\friends;

use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use DB;
use Hash;
use Session;
class ChatController extends Controller
{
    public function sendReequest(Request $request){
        $reciver_id = $request->id;
        $sender_id = Auth::user()->id;
        $confirmed  = 0;

        $counlist = Chat::where('sender_id', '=',$sender_id)
                        ->where('reciver_id','=', $reciver_id)
                        ->orWhere('reciver_id', '=',$sender_id)
                        ->where('sender_id','=', $reciver_id)->get();
        $total= $counlist->count();
    
        if($total<1){
            $created= Chat::create([
                'sender_id'=>$sender_id,
                'reciver_id'=>$reciver_id,
                'confirmed'=>$confirmed
            ]);
            if($created){
                return "yes";
            }else{
                return "no";
            }
    
        }else{
            return "You cannot sent more than on request one user";
        }
    }    

    public function acceptReequest(Request $request){
            $sender_id = $request->id;
            $receiver_id = Auth::user()->id;
            $value = Chat::where('sender_id', $sender_id)->where('reciver_id', $receiver_id);
            $value->update(['confirmed' => 1]);
            if($value ){
                    return "you have accepted the request of";
            }else{
                    return "try again ";
            }      
    }

    public function chatgroup($id){
        $receiver_id= $id;
        $myMsg = friends::where('my_id', Auth::user()->id)->where('friend_id', $id)->get();
        $myMsgf = friends::where('my_id', $id)->where('friend_id', Auth::user()->id)->get();

        return view('auth.user.chatgroup', compact('receiver_id','myMsg','myMsgf'));

    }

    public function chatgroupletscahatnew(Request $request){
        $my_message = $request->textvalue;
        $created= friends::create([
        'my_id'=>Auth::user()->id,
        'friend_id'=>$request->sender_id,
        'ny_messgae'=>$my_message
        ]);

        $myMsg = friends::All()->get();
        return $myMsg;

   

    }
        
       
    
        
}
