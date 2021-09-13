<?php

namespace Database\Factories;

use App\Models\Images;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImagesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Images::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Storage::fake('photos');

        $image = UploadedFile::fake()->image('photos-test.jpg');

        return [
            'image' => $image
        ];
    }
}
