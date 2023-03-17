[2:05 pm, 17/03/2023] Saddam: <?php

namespace App\Helpers;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class AppHelpers
{
    /**
     * Checks whether a value is suitable for use as an ID.
     */
    public static function isValidId($val): bool
    {
        return is_numeric($val) && $val > 0 && !is_float($val);
    }

    public static function isProd(): bool
    {
        return strtolower(config('app.env')) == 'production';
    }

    public static function isDev(): bool
    {
        return strtolower(config('app.env')) == 'local';
    }

    /**
     * Check if the given class implements the given interface
     */
    public static function classDoesImplement(string $class, string $interface)…
[2:05 pm, 17/03/2023] Saddam: */
    public static function formatDate(Carbon|string|null $date, $outFormat = 'd/m/Y')
    {
        return self::carbonParse($date)?->format($outFormat);
    }

    /**
     * Wrapper for Carbon::parse, except a null date returns null
     */
    public static function carbonParse($date): Carbon|null
    {
        if (!$date) return null;

        try {
            return Carbon::parse($date);
        } catch (InvalidFormatException $e) {
            return null;
        }
    }

    /**
     * Checks whether a given date string matches the expected format.
     */
    public static function dateStringMatchesFormat(string $date, string $format)
    {
        // If we have time components, override the format parameter to allow with or without seconds
        $components = substr_count($date, ':');
        if ($components) {
            $format = $components == 2 ? 'Y-m-d H:i:s' : 'Y-m-d H:i'; // value contains seconds?
        }

        try {
            $carbon = Carbon::createFromFormat($format, $date);
            return $carbon->isValid();
        } catch (InvalidFormatException $e) {
            return false;
        }
    }

    /**
     * Perform a generic keyword search on the given builder
     */
    public static function keywordSearch($builder, array $searchFields, ?string $term, bool $leftAnchor = false, bool $splitSpaces = true)
    {
        // Do nothing if no term provided
        if (!$term) return $builder;

        // Attach a where filter for each keyword and search field.
        $builder->where(function ($builder) use ($searchFields, $term, $leftAnchor, $splitSpaces) {
            // Treat space as separate search tokens?
            $tokens = $splitSpaces ? explode(' ', $term) : [$term];

            foreach ($tokens as $token) {
                $keyword = (!$leftAnchor ? '%' : '') . $token . '%';
                $builder->where(function ($builder) use ($searchFields, $keyword) {
                    foreach ($searchFields as $field) {
                        $builder->orWhere($field, 'ilike', $keyword);
                    }
                });
            }
        });

        // Always include search on ID field.
        $builder->orWhereRaw($builder->qualifyColumn('id') . '::text = ?', [$term]);

        return $builder;
    }

    /**
     * Easily convert an enum into an array of key value pairs
     */
    public static function enumToAssociativeArray(string $enumClass)
    {
        return collect($enumClass::cases())
            ->mapWithKeys(fn ($item) => [$item->name => $item->value]);
    }

    /**
     * Encode an image into a base64 string
     */
    public static function base64EncodeImage(string $pathToImage)
    {
        $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
        $data = file_get_contents($pathToImage);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    /**
     * Configure a new browsershot instance for all our PDF reports
     * Ensure correct paths are set
     */
    public static function getBrowsershotBuilder(string $html)
    {
        // Ensure that on windows NODE_PATH is set so that browsershot
        // can find globally installed puppeteer
        if (AppHelpers::isDev()) {
            putenv("NODE_PATH=" . config('constants.node_path'));
        }

        return Browsershot::html($html)
            ->setNodeBinary(config('constants.node_bin_path'));
    }
}
