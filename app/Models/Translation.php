<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;
    protected $fillable = ['key'];

    public function values()
    {
        return $this->hasMany(TranslationValue::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'translation_tag', // explicitly define pivot table
            'translation_id',
            'tag_id'
        );
    }
}
