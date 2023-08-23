<?php

use Illuminate\Support\Arr;

function static_rev(string $path): ?string
{
    $path = ltrim($path, '/');
    $manifest = json_decode(file_get_contents(public_path('/static/manifest.json')),JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR);

    if (($searchedFile = Arr::get($manifest, $path)) && Arr::has($searchedFile, 'file')) {
        return asset('/static/' . Arr::get($searchedFile, 'file'));
    }

    return null;
}
