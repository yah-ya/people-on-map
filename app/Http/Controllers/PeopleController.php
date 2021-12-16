<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public static function getDistanceWith(People $people,float $lat,float $lon):int
    {
        return Controller::getDistanceFromLatLonInKm($people->lat,$people->lon,$lat,$lon);
    }


}
