<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncStringProducts extends Command
{
    protected $signature = 'products:sync-strings';
    protected $description = 'Sync electric guitar single strings from CSV';

    public function handle()
    {
        $path = 'import/strings_electric_singles.csv';

        if (!Storage::exists($path)) {
            $this->error("CSV not found at storage/app/{$path}");
            return Command::FAILURE;
        }

        $content = trim(Storage::get($path));
        if ($content === '') {
            $this->error('CSV is empty');
            return Command::FAILURE;
        }

        $rows = array_map('str_getcsv', preg_split("/\r\n|\n|\r/", $content));
        $header = array_shift($rows);

        $created = 0;
        $updated = 0;

        foreach ($rows as $row) {
            if (count($row) !== count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            $key = [
                'brand' => $data['brand'],
                'model' => $data['model'],
                'gauge' => $data['gauge'],
                'description' => $data['description'], // material
            ];

            // Assign image based on manufacturer
            $brandLower = strtolower(str_replace(' ', '', $data['brand']));
            $imageMap = [
                'daddario' => 'images/daddario.jpg',
                'ernieball' => 'images/ernieball.jpg',
            ];
            $assignedImage = $imageMap[$brandLower] ?? null;

            // Catalog: always updated
            $catalogValues = [
                'price' => (float) $data['price'],
                'image' => $assignedImage,
            ];

            // Stock: applied only on creation
            $initialStock = (int) $data['stock'];

            $product = Product::where($key)->first();

            if ($product) {
                $product->update($catalogValues);
                $updated++;
            } else {
                Product::create($key + $catalogValues + ['stock' => $initialStock]);
                $created++;
            }
        }

        $this->info("Sync done. Created: {$created} | Updated: {$updated}");
        return Command::SUCCESS;
    }
}
