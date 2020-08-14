<?php

namespace Tests\Feature;


use Tests\TestCase;

use Illuminate\Http\UploadedFile;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class PageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function csv_list_can_be_seen()
    {
        $this->post('/api/file/create',[
            'csv' => $this->fakeFile()
        ]);

        $response = $this->get('/api/csv');

        $response->assertStatus(200);


    }

    /** @test */
    public function a_single_csv_can_be_seen()
    {
        $this->post('/api/file/create',[
            'csv' => $this->fakeFile()
        ]);

        $response = $this->get('/api/csv/1');

        $response->assertStatus(200);

    }

    public function createFakeFile(){

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
