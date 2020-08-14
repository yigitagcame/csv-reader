<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

use App\Models\Csvfile as Csv;

class FileTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_legit_csv_file_can_be_upload()
    {
        $response = $this->post( '/api/file/create',[
            'csv' => $this->fakeFile()
        ]);

        $response->assertOk();

        $this->assertCount(1,Csv::all());
    }


    /** @test */

    public function a_csv_record_in_database_can_be_download(){

        $this->post('/api/file/create',[
            'csv' => $this->fakeFile()
        ]);

        $response = $this->get('/api/file/1');

        $response->assertOk();

        $response->streamedContent();

    }


    public function fakeFile(){

        $header = 'People,City,Order';
        $row1 = 'People A,City A,10';
        $row2 = 'People B,City B,20';
        $row3 = 'People A,City A,30';
        $row4 = 'People B,City A,40';

        $content = implode("\n", [$header, $row1, $row2, $row3, $row4]);

        return UploadedFile::fake()->createWithContent('test.csv',$content);

    }


}
