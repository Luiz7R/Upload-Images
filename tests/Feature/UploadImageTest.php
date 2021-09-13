<?php

namespace Tests\Feature;

use App\Models\Images;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\assertFileExists;

class UploadImageTest extends TestCase
{

    public function test_images_can_be_uploaded()
    {
        Storage::fake('photos');

        $image = UploadedFile::fake()->image('photos-01.jpg');

        $response = $this->post( route('upImage', ['imgx' => $image]) ); 

        assertFileExists($image);
    }

    public function test_images_can_be_delete()
    {
        $data = Images::factory()->create();
        $imgId = $data->id;

        $response = $this->post( route('delImg', ['id' => $imgId] ) );

        $response->assertStatus(200);

        $response->assertSeeText('Image deleted successfully');
    }
}
