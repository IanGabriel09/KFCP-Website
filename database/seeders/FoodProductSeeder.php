<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use App\Models\CategoryModel;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FoodProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define categories Food packaging
        $paperCups = CategoryModel::create([
            'name' => 'Paper Cups',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Food'
        ]);

        $paperBowls = CategoryModel::create([
            'name' => 'Paper Bowls',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Food'
        ]);

        $mealBoxes = CategoryModel::create([
            'name' => 'Meal Boxes',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Food'
        ]);

        $clamShells = CategoryModel::create([
            'name' => 'Clam Shells',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Food'
        ]);

        $pastryBoxes = CategoryModel::create([
            'name' => 'Pastry Boxes',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Food'
        ]);

        $foodWrappers = CategoryModel::create([
            'name' => 'Food Wrappers',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Food'
        ]);

        $paperBags = CategoryModel::create([
            'name' => 'Paper Bags',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Food'
        ]);

        $cupSleeves = CategoryModel::create([
            'name' => 'Cup Sleeves',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Food'
        ]);


        // Define categoried Industrial packaging
        $coloredBoxes = CategoryModel::create([
            'name' => 'Colored Boxes',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);

        $corrugatedColoredBoxes = CategoryModel::create([
            'name' => 'Corrugated Boxes',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);

        $displayBoxes = CategoryModel::create([
            'name' => 'Display Boxes',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);

        $manuals = CategoryModel::create([
            'name' => 'Manuals',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);

        $brochures = CategoryModel::create([
            'name' => 'Brochures',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);

        $leaflets = CategoryModel::create([
            'name' => 'Leaflets',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);

        $flyers = CategoryModel::create([
            'name' => 'Flyers',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);

        $posters = CategoryModel::create([
            'name' => 'Posters',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);

        $stickers = CategoryModel::create([
            'name' => 'Stickers',
            'uuid' => (string) Str::uuid(),
            'classification' => 'Industrial'
        ]);




        // Product insertion
        $products = [
            /* ------Food Packaging-------- */
            // Paper cups data
            [
                'name' => 'Paper Cups 4oz',
                'description' => 'Sample description for paper cups 4oz',
                'price' => 0.12,
                'category' => $paperCups,
                'image' => 'paperCup_4oz.webp',
            ],
            [
                'name' => 'Paper Cups 6oz',
                'description' => 'Sample description for paper cups 6oz',
                'price' => 0.3,
                'category' => $paperCups,
                'image' => 'paperCup_6oz.webp',
            ],
            [
                'name' => 'Paper Cups 8oz',
                'description' => 'Sample description for paper cups 8oz',
                'price' => 0.5,
                'category' => $paperCups,
                'image' => 'paperCup_8oz.webp',
            ],
            [
                'name' => 'Paper Cups 16oz',
                'description' => 'Sample description for paper cups 16oz',
                'price' => 0.9,
                'category' => $paperCups,
                'image' => 'paperCup_16oz.webp',
            ],
            [
                'name' => 'Paper Cups 22oz',
                'description' => 'Sample description for paper cups 22oz',
                'price' => 1.5,
                'category' => $paperCups,
                'image' => 'paperCup_22oz.webp',
            ],
            [
                'name' => 'Paper Cups 12oz 80D',
                'description' => 'Sample description for paper cups 12oz 80D',
                'price' => 1.4,
                'category' => $paperCups,
                'image' => 'paperCup_12oz80D.webp',
            ],
            [
                'name' => 'Paper Cups 12oz 90D',
                'description' => 'Sample description for paper cups 12oz 90D',
                'price' => 1.6,
                'category' => $paperCups,
                'image' => 'paperCup_12oz90D.webp',
            ],

            // Paper Bowls data
            [
                'name' => 'Paper Bowl 150cc',
                'description' => 'Sample description for paper bowls 150cc',
                'price' => 2.3,
                'category' => $paperBowls,
                'image' => 'paperBowl_150cc.webp',
            ],
            [
                'name' => 'Paper Bowl 260cc',
                'description' => 'Sample description for paper bowls 260cc',
                'price' => 2.4,
                'category' => $paperBowls,
                'image' => 'paperBowl_260cc.webp',
            ],
            [
                'name' => 'Paper Bowl 390cc',
                'description' => 'Sample description for paper bowls 390cc',
                'price' => 2.6,
                'category' => $paperBowls,
                'image' => 'paperBowl_390cc.webp',
            ],
            [
                'name' => 'Paper Bowl 520cc',
                'description' => 'Sample description for paper bowls 520cc',
                'price' => 2.6,
                'category' => $paperBowls,
                'image' => 'paperBowl_520cc.webp',
            ],
            [
                'name' => 'Paper Bowl 550cc',
                'description' => 'Sample description for paper bowls 550cc',
                'price' => 3.0,
                'category' => $paperBowls,
                'image' => 'paperBowl_550cc.webp',
            ],

            // Meal Boxes Data
            [
                'name' => 'Meal Box BHS-1',
                'description' => 'Sample description for Meal Box BHS-1',
                'price' => 2.5,
                'category' => $mealBoxes,
                'image' => 'mealbox-BHS-1.webp',
            ],
            [
                'name' => 'Meal Box BHS-2',
                'description' => 'Sample description for Meal Box BHS-2',
                'price' => 2.8,
                'category' => $mealBoxes,
                'image' => 'mealbox-BHS-2.webp',
            ],
            [
                'name' => 'Meal Box BHS-3',
                'description' => 'Sample description for Meal Box BHS-3',
                'price' => 2.4,
                'category' => $mealBoxes,
                'image' => 'mealbox-BHS-3.webp',
            ],
            [
                'name' => 'Meal Box BHS-4',
                'description' => 'Sample description for Meal Box BHS-4',
                'price' => 2.8,
                'category' => $mealBoxes,
                'image' => 'mealbox-BHS-4.webp',
            ],
            [
                'name' => 'Meal Box BHS-5',
                'description' => 'Sample description for Meal Box BHS-5',
                'price' => 2.2,
                'category' => $mealBoxes,
                'image' => 'mealbox-BHS-5.webp',
            ],
            [
                'name' => 'Chicken Carrier',
                'description' => 'Sample description for chicken carrier',
                'price' => 2.7,
                'category' => $mealBoxes,
                'image' => 'chicken carrier.webp',
            ],

            // Clam shells
            [
                'name' => 'Hotdog Box',
                'description' => 'Sample description for Hotdog Box',
                'price' => 2.6,
                'category' => $clamShells,
                'image' => 'Hotdog Box.webp',
            ],
            [
                'name' => 'Burger Box',
                'description' => 'Sample description for Burger Box',
                'price' => 2.6,
                'category' => $clamShells,
                'image' => 'Burger Box.webp',
            ],
            [
                'name' => 'BGL-1',
                'description' => 'Sample description for BGL-1',
                'price' => 2.4,
                'category' => $clamShells,
                'image' => 'BGL-1.webp',
            ],
            [
                'name' => 'BGL-2',
                'description' => 'Sample description for BGL-2',
                'price' => 2.9,
                'category' => $clamShells,
                'image' => 'BGL-2.webp',
            ],

            // Pastry Boxes
            [
                'name' => 'Donut Box 6s',
                'description' => 'Sample description for Donut Box 6s',
                'price' => 4.4,
                'category' => $pastryBoxes,
                'image' => 'Donut_6s.webp',
            ],
            [
                'name' => 'Donut Box 12s',
                'description' => 'Sample description for Donut Box 12s',
                'price' => 4.3,
                'category' => $pastryBoxes,
                'image' => 'Donut_12s.webp',
            ],
            [
                'name' => 'Pie Box W/PVC',
                'description' => 'Sample description for Pie Box W/PVC',
                'price' => 4.1,
                'category' => $pastryBoxes,
                'image' => 'Pie_Box.webp',
            ],
            [
                'name' => 'Small Pastry Box W/PVC',
                'description' => 'Sample description for Small Pastry Box W/PVC',
                'price' => 4.3,
                'category' => $pastryBoxes,
                'image' => 'small_pastryBox.webp',
            ],
            [
                'name' => 'Cake Box',
                'description' => 'Sample description for Cake Box',
                'price' => 4.0,
                'category' => $pastryBoxes,
                'image' => 'cake_box.webp',
            ],

            // Food wrappers
            [
                'name' => 'Flat-Type Wrapper',
                'description' => 'Sample description for Flat-Type Wrapper',
                'price' => 1.1,
                'category' => $foodWrappers,
                'image' => 'FlatType.webp',
            ],
            [
                'name' => 'L-Type Wrapper',
                'description' => 'Sample description for Flat Type Wrapper',
                'price' => 1.1,
                'category' => $foodWrappers,
                'image' => 'L-type.webp',
            ],

            // Paper Bags
            [
                'name' => '#4 SOS Bag',
                'description' => 'Sample description for #4 SOS Bag',
                'price' => 1.5,
                'category' => $paperBags,
                'image' => 'sos-4.webp',
            ],
            [
                'name' => '#8 SOS Bag',
                'description' => 'Sample description for #8 SOS Bag',
                'price' => 1.1,
                'category' => $paperBags,
                'image' => 'sos-8.webp',
            ],
            [
                'name' => '#12 SOS Bag',
                'description' => 'Sample description for #12 SOS Bag',
                'price' => 1.8,
                'category' => $paperBags,
                'image' => 'sos-8.webp',
            ],
            [
                'name' => 'Satchel Bag',
                'description' => 'Sample description for Satchel Bag',
                'price' => 0.5,
                'category' => $paperBags,
                'image' => 'satchel bag.png',
            ],

            // Cup Sleeves
            [
                'name' => 'Coffee Sleeve',
                'description' => 'Sample description for Coffee Sleeve',
                'price' => 0.2,
                'category' => $cupSleeves,
                'image' => 'CoffeSleeve.webp',
            ],
            [
                'name' => 'Air Holder',
                'description' => 'Sample description for Air Holder',
                'price' => 0.1,
                'category' => $cupSleeves,
                'image' => 'AirHolder.webp',
            ],
            [
                'name' => 'Take Away Cup Holder',
                'description' => 'Sample description for Take Away Cup Holder',
                'price' => 0.4,
                'category' => $cupSleeves,
                'image' => 'TakeAwayHolder.webp',
            ],

            /* ------Industrial Packaging-------- */
            [
                'name' => 'Colored Boxes',
                'description' => 'Sample description for Colored Boxes',
                'price' => 5.0,
                'category' => $coloredBoxes,
                'image' => 'ColoredBox.webp',
            ],

            [
                'name' => 'Corrugated Boxes',
                'description' => 'Sample description for Corrugated Boxes',
                'price' => 5.0,
                'category' => $corrugatedColoredBoxes,
                'image' => 'CorrugatedBox.webp',
            ],

            [
                'name' => 'Display Boxes',
                'description' => 'Sample description for Display Boxes',
                'price' => 5.0,
                'category' => $displayBoxes,
                'image' => 'DisplayBox.webp',
            ],

            [
                'name' => 'Manuals',
                'description' => 'Sample description for Manuals',
                'price' => 5.0,
                'category' => $manuals,
                'image' => 'manual.webp',
            ],

            [
                'name' => 'Brochures',
                'description' => 'Sample description for Brochures',
                'price' => 5.0,
                'category' => $brochures,
                'image' => 'brochure.webp',
            ],

            [
                'name' => 'Leaflets',
                'description' => 'Sample description for Leaflets',
                'price' => 5.0,
                'category' => $leaflets,
                'image' => 'leaflets.webp',
            ],

            [
                'name' => 'Flyers',
                'description' => 'Sample description for Flyers',
                'price' => 5.0,
                'category' => $flyers,
                'image' => 'flyers.webp',
            ],
      
            [
                'name' => 'Posters',
                'description' => 'Sample description for Posters',
                'price' => 5.0,
                'category' => $posters,
                'image' => 'poster.webp',
            ],

            [
                'name' => 'Stickers',
                'description' => 'Sample description for Stickers',
                'price' => 5.0,
                'category' => $stickers,
                'image' => 'stickers.webp',
            ],

        ];

        foreach ($products as $product) {
            ProductModel::create([
                'uuid' => (string) Str::uuid(),
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'category_uuid' => $product['category']->uuid,
                'image' => $product['image'],
            ]);
        }
    }
}
