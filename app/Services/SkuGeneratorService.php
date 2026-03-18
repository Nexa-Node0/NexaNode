<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class SkuGeneratorService
{
    /**
     * Generate a unique 8-character SKU.
     *
     * @return string
     */
    public static function generate(): string
    {
        do {
            // Generate a random 8-character alphanumeric code
            $sku = strtoupper(Str::random(8, '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'));
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }

    /**
     * Generate a custom SKU with optional prefix and ensure uniqueness.
     *
     * @param string $prefix Optional prefix (e.g., "PROD")
     * @return string
     */
    public static function generateWithPrefix(string $prefix = ''): string
    {
        $maxAttempts = 100;
        $attempts = 0;

        do {
            $attempts++;
            
            if ($attempts > $maxAttempts) {
                throw new \RuntimeException('Unable to generate unique SKU after ' . $maxAttempts . ' attempts');
            }

            // Generate random suffix to reach 8 characters
            $suffixLength = 8 - strlen($prefix);
            $suffix = strtoupper(Str::random($suffixLength, '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'));
            $sku = $prefix . $suffix;
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }

    /**
     * Validate if a SKU is in the correct format (8 characters, alphanumeric).
     *
     * @param string $sku
     * @return bool
     */
    public static function isValidFormat(string $sku): bool
    {
        return strlen($sku) === 8 && preg_match('/^[A-Z0-9]{8}$/i', $sku);
    }
}
