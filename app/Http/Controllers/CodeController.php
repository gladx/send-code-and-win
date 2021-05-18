<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['code' => 'required', 'quantity' => 'required']);

        if ($validator->fails()) {
           return response()->json($validator->errors(), 422);
        }

        Code::create($request->all());

        return response()->json(['status' => 'ok']);
    }
}
