<?php

namespace App\Actions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ExportTranslations
{
    public function handle(): array
    {
        return Cache::remember('translations.export.v1', 60, function () {

            $rows = DB::table('translations')
                ->join('translation_values', 'translations.id', '=', 'translation_values.translation_id')
                ->select(
                    'translations.key',
                    'translation_values.locale',
                    'translation_values.value'
                )
                ->orderBy('translations.id')
                ->get();

            $result = [];

            foreach ($rows as $row) {
                // direct assignment (fastest possible structure build)
                $result[$row->key][$row->locale] = $row->value;
            }

            return $result;
        });
    }
}
