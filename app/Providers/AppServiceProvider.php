<?php

namespace App\Providers;

use App\Helpers\AppHelpers;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMacros();
        $this->registerCustomValidators();
    }

    private function registerMacros()
    {
        // Dump the raw sql string from the query builder or eloquent query builder
        // https://stackoverflow.com/a/53078018/804484
        \Illuminate\Database\Query\Builder::macro('toRawSql', function () {
            return array_reduce($this->getBindings(), function ($sql, $binding) {
                return preg_replace('/\?/', is_numeric($binding) ? $binding : "'" . $binding . "'", $sql, 1);
            }, $this->toSql());
        });

        EloquentBuilder::macro('ddSql', function () {
            /** @var EloquentBuilder */
            $self = $this;
            $self->getQuery()->ddSql();
        });
    }
    /**
     * Register any custom validation rules.
     */
    private function registerCustomValidators()
    {
        Validator::extend('valid_id', fn ($attribute, $value) => AppHelpers::isValidId($value));
        Validator::extend('percentage', fn ($attribute, $value) => $value >= 0 && $value <= 100);

        // File must be valid and under the size restriction of our laravel-medialibrary
        Validator::extend('valid_file', function ($attribute, $value) {
            return $value instanceof \Illuminate\Http\UploadedFile &&
                $value->isValid() &&
                $value->getSize() < config('media-library.max_file_size');
        });
    }
}
