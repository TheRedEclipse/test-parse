<?php

namespace Tests\Feature;

use App\Imports\RowImport;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class RowTest extends TestCase
{
    /** 
     * test list of rows
     */
    public function test_get_list_of_rows()
    {
        $this->actingAs(User::first());

        $response = $this->getJson('/api/files');

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);
    }
}
