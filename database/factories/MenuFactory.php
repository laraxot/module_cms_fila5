<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Models\Menu;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Menu>
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
<<<<<<< .merge_file_0fB6Nc
     * @return array<string, mixed>
=======
    * @return array<string, mixed>
>>>>>>> .merge_file_y20w6F
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'items' => fake()->text,
        ];
    }
}
