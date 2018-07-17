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
        \Blade::directive(
            'errorblock',
            function ($expression) {
                $expression = trim($expression, "\"'");
                $directive = "<?php ";
                $directive .= " \$field = '{$expression}';";
                $directive .= " \$variables = array_except(get_defined_vars(), ['__data', '__path']);";
                $directive .= " \$rendered = \$__env->make('shared.partials._error_block', \$variables)->render();";
                $directive .= " echo \$rendered; ?>";
                return $directive;
            }
        );

        \Blade::directive(
            'csrf',
            function () {
                return "<?php echo csrf_field(); ?>";
            }
        );

        \Blade::directive(
            'method',
            function ($field) {
                $field = strtoupper(trim($field, "\"'"));
                $allowed_methods = ['PUT', 'PATCH', 'DELETE'];

                if (in_array($field, $allowed_methods)) {
                    return method_field($field);
                }

                $exception_message = "Invalid form method [{$field}].";
                throw new \InvalidArgumentException($exception_message, 500);
            }
        );

        \Blade::directive(
            'fa',
            function ($expression) {
                return sprintf('<i aria-hidden="true" class="fa fa-%s"></i>', trim($expression, "\"'"));
            }
        );

        \Blade::extend(
            function ($view) {
                $pattern = '/@cached_include\((.*)\)/';
                return preg_replace($pattern, "<?php echo cached_include($1); ?>", $view);
            }
        );
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
