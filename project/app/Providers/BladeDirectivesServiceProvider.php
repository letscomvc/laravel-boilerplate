<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive('errorblock', function ($expression) {
            $expression = trim($expression, "\"'");
            $directive = "<?php ";
            $directive .= "\$field = '{$expression}';";
            $directive .= "echo \$__env->make('shared.partials._error_block' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
            return $directive;
        });

        \Blade::directive('csrf', function () {
            return "<?php echo csrf_field() ?>";
        });

        \Blade::directive('method', function ($field) {
            $field = strtoupper(trim($field, "\"'"));
            if (in_array($field, ['PUT', 'PATCH', 'DELETE'])) {
                return "<?php echo method_field('{$field}') ?>";
            }

            $exception_message = "Invalid form method [{$field}].";
            throw new \InvalidArgumentException($exception_message, 500);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
