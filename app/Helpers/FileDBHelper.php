<?php
namespace App\Helpers;
use App\Models\People;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class FileDBHelper{

    private $file = "";
    private $columns = "";
    private $lines = "";
    private $ppl = null;
    public function __construct()
    {
        $this->file = storage_path('app\public\mock.txt');
        $this->ppl = collect();
        $this->readFile();
    }

    private function readFile():void
    {
        //get lines
        $array = explode("\n",File::get($this->file));

        //first line is our columns
        $this->columns = rtrim($array[0]);

        //remove the columns from the array
        array_shift($array);
        $this->lines = $array;


    }

    public function getColumns():string
    {
        return $this->columns;
    }

    public function initRows():void
    {

        $this->ppl = collect();
        foreach($this->lines as $line){
            if(empty($line))
                continue;
            //fetch the attrs from each line
            $attrs = explode(',',$line);

            $ppl = People::makeFromAttrs($attrs);
            $this->ppl->add($ppl);
        }

    }

    public function filterGender($gender)
    {
        return $this->ppl= $this->ppl->where('gender',$gender)->values();
    }

    public function filterCoordinates($cityLatLong):Collection {
        $cityLatLon = explode(',',$cityLatLong);
        $filteredValues = $this->filterDbItemsByCoordinates($cityLatLon);
        return $this->ppl = $filteredValues;
    }

    public function filterNameOrFamily($txt){
        return $this->ppl = $this->ppl->filter(function($item) use($txt){
            return strpos($item->first_name,$txt) === 0 || strpos($item->last_name,$txt) === 0;
        })->values();
    }

    public function all():array
    {
        return $this->ppl->all();
    }

    public function getIndex($line):People
    {
        return $this->ppl[$line];
    }


    private function filterDbItemsByCoordinates($cityLatLon): Collection
    {
        $filteredValues = collect();
        foreach($this->ppl->all() as $ppl){
            if(DistanceHelper::getDistanceFromLatLonInKm($ppl->lat,$ppl->lon,$cityLatLon[0],$cityLatLon[1])<2000){
                $filteredValues->add($ppl);
            }
        }
        return $filteredValues;
    }

}
?>
