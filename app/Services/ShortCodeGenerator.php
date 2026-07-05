<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Str;

class ShortCodeGenerator
{
    private const LENGTH = 6;

    public function generate(): string
    {
        do {
            $code = Str::random(self::LENGTH);
        } while (Link::query()->where('short_code', $code)->exists());

        return $code;
    }
}
