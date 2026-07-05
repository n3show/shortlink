<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Services\ShortCodeGenerator;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['short_code'] = app(ShortCodeGenerator::class)->generate();

        return $data;
    }
}
