<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function code()
    {
        return $this->belongsTo(Code::class);
    }

    public function getCode()
    {
        return $this->code->code;
    }
    
}
