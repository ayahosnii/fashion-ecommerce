<?php

namespace Database\Seeders;
use App\Models\admin\Category;
use App\Models\admin\CategoryTranslation;
use App\Models\admin\Product;
use App\Models\admin\ProductTranslation;
use Illuminate\Database\Seeder;
use Astrotomic\Translatable\Locales;
use Illuminate\Support\Arr;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the 'products' table with fashion-related data and fashion names
        $this->seedCategories();
    }

    /**
     * Seed the 'products' table with fashion-related data and fashion names.
     *
     * @return void
     */
    private function seedCategories()
    {
        // Use Faker to generate fake data for products
        $faker = \Faker\Factory::create();

        // Generate 20 fashion products
        for ($i = 1; $i <= 20; $i++) {
            $category = [
                'slug' => $faker->unique()->slug,
                'parent_id' => 0,
                'is_active' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Create the product in the 'products' table
            $category = Category::create($category);

            // Add translations for the fashion name in English and Arabic
            $locales = Arr::flatten(app(Locales::class)->all());
            foreach ($locales as $locale) {
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'locale' => $locale,
                    'name' => $this->getRandomFashionName(),
                ]);
            }
        }
    }

    /**
     * Get a random fashion-related name.
     *
     * @return string
     */
    private function getRandomFashionName()
    {
        $fashionCategories = [
            'Dresses',
            'T-shirts',
            'Blouses',
            'Jeans',
            'Jackets',
            'Skirts',
            'Sweaters',
            'Jumpsuits',
            'Handbags',
            'Sneakers',
            'Watches',
            'Sunglasses',
            'Hats',
            'Bracelets',
        ];


        return Arr::random($fashionCategories);
    }
}
