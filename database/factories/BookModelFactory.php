<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookModel>
 */
class BookModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'author_id' => \App\Models\AuthorModel::factory(), // create an author or assign one
            'title' => $this->faker->sentence(3), // random 3-word title
            'isbn' => $this->faker->unique()->isbn13(),
            'publication_year' => $this->faker->year(),
            'genre' => $this->faker->word(),
            'available_copies' => $this->faker->numberBetween(0, 20),
        ];
    }
}
