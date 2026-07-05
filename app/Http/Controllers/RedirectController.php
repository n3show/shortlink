<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Link;

class RedirectController extends Controller
{
    public function __invoke(Request $request, string $shortCode): RedirectResponse
    {
        $link = Link::query()
            ->where('short_code', $shortCode)
            ->firstOrFail();

        $link->clicks()->create([
            'ip_address' => $request->ip(),
            'clicked_at' => now(),
        ]);

        return redirect()->away($link->original_url);
    }
}