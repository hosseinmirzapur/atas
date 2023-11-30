<?php

use App\Exceptions\CustomException;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('jsonResponse')) {
    /**
     * @param null $data
     * @param bool $success
     * @param bool $exist
     * @return JsonResponse
     */
    function jsonResponse($data = null, bool $success = true, bool $exist = true): JsonResponse
    {
        if ($exist) {
            return $success ? response()->json([
                'success' => $success,
                'data' => $data == null ? trans('messages.SUCCESS') : $data
            ]) : response()->json([
                'success' => false,
                'message' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $data
            ], 404);
        }
    }
}
if (!function_exists('currentUser')) {
    /**
     * @return Authenticatable|User|Admin|null
     */
    function currentUser(): Authenticatable|User|Admin|null
    {
        return auth()->user();
    }
}

if (!function_exists('exists')) {
    /**
     * @param $item
     * @return bool
     */
    function exists($item): bool
    {
        return isset($item) && $item != null && $item != '';
    }
}

if (!function_exists('handleFile')) {
    /**
     * @param $path
     * @param $file
     * @return string|null
     */
    function handleFile($path, $file): string|null
    {
        if ($file == null || $file == '') {
            return null;
        }
        $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($path, $file, $filename);
        return $path . '/' . $filename;
    }
}

if (!function_exists('filterRequest')) {
    /**
     * @param array $data
     * @return array
     * @throws CustomException
     */
    function filterRequest(array $data): array
    {
        foreach ($data as $k => $v) {
            if (!exists($k)) {
                unset($data);
            }
        }
        if (empty($data)) {
            throw new CustomException(trans('messages.NO_DATA_SENT'));
        }
        return $data;
    }
}

if (!function_exists('formatTags')) {
    /**
     * @param string $tags
     * @return array
     */
    function formatTags(string $tags): array
    {
        return explode(' ', $tags);
    }
}
