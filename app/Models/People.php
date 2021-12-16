<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;
    protected $fillable=['id','first_name','last_name','gender', 'lat','lon'];

    public static function makeFromAttrs($attrs){

        $ppl = new People([
            'id'=>$attrs[0],
            'first_name'=>$attrs[1],
            'last_name'=>$attrs[2],
            'gender'=>$attrs[3],
            'lat'=>$attrs[4],
            'lon'=>$attrs[5],
        ]);
        return $ppl;
    }
}
