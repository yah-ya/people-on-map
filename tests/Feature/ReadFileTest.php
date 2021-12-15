<?php

namespace Tests\Feature;

use App\Helpers\FileDBHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadFileTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    private $db = null;

    public function test_read_file()
    {
        $this->db = new FileDBHelper();
        $columns = $this->db->getColumns();
        $this->assertEquals('id,first_name,last_name,gender,lat,lon',$columns,'Columns does not match');
    }

    public function test_count_males(){
        $this->db = new FileDBHelper();
        $this->db->initRows();

        $this->assertCount(509,
            $this->db->filterGender('Male')->all()
        );
    }

    public function test_count_females(){
        $this->db = new FileDBHelper();
        $this->db->initRows();

        $this->assertCount(491,
            $this->db->filterGender('Female')->all()
        );
    }

    public function test_filter_location(){

    }




}
