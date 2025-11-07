<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // <- pastikan ini di-import

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // Gunakan $this->faker (paling kompatibel lintas versi)
        $name = $this->faker->unique()->words(3, true);

        // Ambil satu category id kalau sudah ada, kalau belum biarkan null: nanti di seeder kita tangani.
        $categoryId = Category::query()->inRandomOrder()->value('id');

        return [
            'category_id' => $categoryId, // biarkan null kalau belum ada; seeder akan pastikan ada Category dulu
            'name' => ucfirst($name),
            'slug' => Str::slug($name . '-' . $this->faker->unique()->numerify('###')),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(5_000_000, 80_000_000),
            'stock' => $this->faker->numberBetween(0, 10),
            'condition' => $this->faker->randomElement(['classic', 'custom']),
            'thumbnail' => null,
            'is_active' => true,
        ];
    }
}
