<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;

class UserCodeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['code' => 'required|exists:codes,code', 'phone' => 'required']);

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        $redis = Redis::connection();
        
        $redis->zadd('code:' . $request->code, $request->server('REQUEST_TIME_FLOAT'),  $request->phone);

        return response()->json(['status' => 'ok']);
    }


    public function checkWin($code, $phone)
    {
        $registerCode = Code::whereCode($code)->first();

        $userCode = UserCode::where(['code_id' => $registerCode->id ?? -1, 'phone' => $phone])->exists();

        if($userCode && $registerCode) {
            return response()->json(['status' => 'ok']);
        }
        
        return  response()->json(['status' => 'nok'], 404);
    }
}
