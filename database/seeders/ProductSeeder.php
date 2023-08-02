<?php

namespace Database\Seeders;
use App\Models\admin\Product;
use App\Models\admin\ProductTranslation;
use Illuminate\Database\Seeder;
use Astrotomic\Translatable\Locales;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the 'products' table with fashion-related data and fashion names
        $this->seedProducts();
    }

    /**
     * Seed the 'products' table with fashion-related data and fashion names.
     *
     * @return void
     */
    private function seedProducts()
    {
        // Use Faker to generate fake data for products
        $faker = \Faker\Factory::create();

        // Generate 20 fashion products
        for ($i = 1; $i <= 20; $i++) {
            $product = [
                'slug' => $faker->unique()->slug,
                'price' => $faker->randomFloat(2, 20, 200),
                'sale_price' => $faker->randomFloat(2, 10, 150),
                'sale_price_type' => $faker->randomElement(['fixed', 'percentage', null]),
                'sale_price_start' => $faker->dateTimeBetween('-1 month', 'now'),
                'sale_price_end' => $faker->dateTimeBetween('now', '+1 month'),
                'selling_price' => $faker->randomFloat(2, 15, 180),
                'sku' => $faker->ean8,
                'manage_stock' => $faker->boolean,
                'qty' => $faker->randomNumber(2),
                'in_stock' => $faker->boolean,
                'viewed' => $faker->numberBetween(0, 1000),
                'is_active' => $faker->boolean,
                'brand_id' => $faker->randomNumber(2),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Create the product in the 'products' table
            $product = Product::create($product);

            // Add translations for the fashion name in English and Arabic
            $locales = Arr::flatten(app(Locales::class)->all());
            foreach ($locales as $locale) {
                ProductTranslation::create([
                    'product_id' => $product->id,
                    'locale' => $locale,
                    'name' => $this->getRandomFashionName(),
                    'description' => $faker->paragraph,
                    'short_description' => $faker->sentence,
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
        $fashionNames = [
            'Chic Dress',
            'Trendy T-shirt',
            'Elegant Blouse',
            'Stylish Jeans',
            'Classy Jacket',
            'Fashionable Skirt',
            'Modish Sweater',
            'Hip Jumpsuit',
            'Fancy Handbag',
            'Cool Sneakers',
            'Glamorous Watch',
            'Sleek Sunglasses',
            'Sophisticated Hat',
            'Trendsetting Bracelet',
        ];

        return Arr::random($fashionNames);
    }
}
