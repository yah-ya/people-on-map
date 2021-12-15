<?php
namespace App\Helpers;
use App\Models\People;
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
        $this->ppl = new Collection();
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

        foreach($this->lines as $line){
            $attrs = explode(',',$line);
            $ppl = new People;
            $ppl->id = @$attrs[0];
            $ppl->first_name = @$attrs[1];
            $ppl->last_name = @$attrs[2];
            $ppl->gender = @$attrs[3];
            $ppl->lat = @$attrs[4];
            $ppl->lon = @$attrs[5];
            $this->ppl->put($ppl->id,$ppl);
        }

    }
//    private function setColumns():void
//    {
//        $this->columns = rtrim(strtok($this->content, PHP_EOL));
//    }

    public function filterGender($gender):Collection
    {
        return $this->ppl->where('gender',$gender);
    }

}
?>
