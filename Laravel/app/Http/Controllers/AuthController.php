<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $successStatus = 200;
    public function get_user(){
        $user=User::all();
        $success['user']=$user;
        $success['status']=200;
        return response()->json(['success' => $success]);
    }

    public function login_app(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required',
            'notification_token'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user=User::where('email','=',$request->email)->where('password','=',$request->password)->first();
        if($user){
            $user->notification_token=$request->notification_token;
            $user->save();
            $success['user']=$user;
            $success['status']=200;
            $success['message']='Login Successfully';
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            $success['status']=400;
            $success['message']='Incorrect Credentials';
            return response()->json(['error' => $success]);
        }
    }

    public function logout($id){
        $user=User::find($id);
        if($user){
            $user->notification_token=null;
            $user->save();
            $success['user']=$user;
            $success['status']=200;
            $success['message']='Logout Successfully';
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            $success['status']=400;
            $success['message']='No User found';
            return response()->json(['error' => $success]);
        }
    }
}
