<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function accounts(Request $request){
        
        
        $request->validate([
            'company_email' => 'required',
            'password' => 'required'
            ]);
            
            
            
        $account = Account::where('company_email',$request->company_email)->where('password', $request->password)->first();
        
        if($account){
            
            $success['status'] = 200;
            $success['message'] = "Data found successfully";
            $success['data'] = $account;
            
            return response()->json(['success' => $success]);
        }else{
            
            $error['status'] = 400;
            $error['message'] = "Invalid Data";
            
            return response()->json(['error' => $error]);
        }
    }
}
