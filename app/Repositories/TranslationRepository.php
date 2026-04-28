<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Translation;
use App\Models\TranslationValue;
use Illuminate\Support\Facades\DB;

class TranslationRepository
{
    /**
     * Search translations (optimized query)
     */
    public function search(array $filters)
    {
        return Translation::query()
            ->select(['id', 'key'])
            ->with([
                'values:id,translation_id,locale,value',
                'tags:id,name'
            ])

            ->when($filters['key'] ?? null, function ($q, $key) {
                $q->where('key', 'like', "%{$key}%");
            })

            ->when($filters['tag'] ?? null, function ($q, $tag) {
                $q->whereHas('tags', function ($t) use ($tag) {
                    $t->where('name', 'like', "%{$tag}%");
                });
            })

            ->when($filters['content'] ?? null, function ($q, $content) {
                $q->whereHas('values', function ($v) use ($content) {
                    $v->where('value', 'like', "%{$content}%");
                });
            })

            ->latest('id')
            ->paginate(100);
    }

    /**
     * Get translation export (FAST RAW SQL - no Eloquent overhead)
     */
    public function export(string $locale)
    {
        return DB::table('translation_values as tv')
            ->join('translations as t', 't.id', '=', 'tv.translation_id')
            ->where('tv.locale', $locale)
            ->select('t.key', 'tv.value')
            ->pluck('tv.value', 't.key');
    }

    /**
     * Create translation
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $translation = Translation::create([
                'key' => $data['key']
            ]);

            foreach ($data['values'] as $value) {
                $translation->values()->create($value);
            }

            if (!empty($data['tags'])) {

                $tagIds = collect($data['tags'])->map(function ($tag) {
                    return Tag::firstOrCreate([
                        'name' => $tag
                    ])->id;
                });

                $translation->tags()->sync($tagIds);
            }

            return $translation->load(['values', 'tags']);
        });
    }

    /**
     * Update translation
     */
    public function update(Translation $translation, array $data)
    {
        return DB::transaction(function () use ($translation, $data) {

            if (isset($data['key'])) {
                $translation->update(['key' => $data['key']]);
            }

            if (!empty($data['values'])) {
                $translation->values()->delete();

                foreach ($data['values'] as $value) {
                    $translation->values()->create($value);
                }
            }

            return $translation->load(['values', 'tags']);
        });
    }
}
