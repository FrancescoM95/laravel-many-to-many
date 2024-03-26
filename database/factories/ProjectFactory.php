<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        Storage::makeDirectory('project_images');

        $title = fake()->text(20);
        $slug =  Str::slug($title);

        $img = fake()->image(null, 250, 250);
        $img_url = Storage::putFileAs('project_images', $img, "$slug.png");

        $type_ids = Type::pluck('id')->toArray();
        $type_ids[] = null;

        return [
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->paragraph(5, true),
            'image' => $img_url,
            'type_id' => Arr::random($type_ids)
        ];
    }
}
