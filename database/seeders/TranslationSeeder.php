<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;
use App\Models\TranslationValue;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        // STEP 1: Create tags (only once)
        $tags = ['web', 'mobile', 'desktop', 'api', 'ecommerce'];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag]);
        }

        $batchSize = 100;
        $total = 1000;

        for ($i = 0; $i < $total; $i += $batchSize) {

            $translations = [];

            // STEP 2: Insert translations (bulk)
            for ($j = 0; $j < $batchSize; $j++) {
                $translations[] = [
                    'key' => 'key_' . ($i + $j) . '_' . uniqid(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Translation::insert($translations);

            // Fetch last inserted batch
            $inserted = Translation::orderByDesc('id')
                ->limit($batchSize)
                ->get();

            $values = [];
            $pivot  = [];

            $tagIds = Tag::pluck('id')->toArray();

            foreach ($inserted as $translation) {

                // STEP 3: Translation values (3 locales)
                foreach (['en', 'fr', 'es'] as $locale) {
                    $values[] = [
                        'translation_id' => $translation->id,
                        'locale' => $locale,
                        'value' => strtoupper($locale) . ' text ' . $translation->key,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // STEP 4: random tags (pivot)
                $randomTags = collect($tagIds)->random(2);

                foreach ($randomTags as $tagId) {
                    $pivot[] = [
                        'translation_id' => $translation->id,
                        'tag_id' => $tagId,
                    ];
                }
            }

            TranslationValue::insert($values);
            DB::table('translation_tag')->insert($pivot);

            echo "Inserted batch: {$i} - " . ($i + $batchSize) . PHP_EOL;
        }
    }
}