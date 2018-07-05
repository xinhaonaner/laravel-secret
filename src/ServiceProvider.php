<?php

namespace Xinhaonaner\Secret;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Xinhaonaner\Secret\Exceptions\InvalidConfigException;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->isLumen()) {
            $this->app->middleware([HandleCheck::class]);
        } else {
            //$this->generateKey();

            $this->publishes([$this->configPath() => config_path('api-secret.php')]);

            /** @var \Illuminate\Foundation\Http\Kernel $kernel */
            $kernel = $this->app->make(Kernel::class);

            $kernel->pushMiddleware(HandleApiSecret::class);

            // When the HandleCors middleware is not attached globally, add the PreflightCheck
            //if ( !$kernel->hasMiddleware(HandleApiSecret::class)) {
            //    $kernel->prependMiddleware(HandleCheck::class);
            //}
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'api-secret');

        $this->app->singleton(ApiSecretService::class, function ($app) {
            return new ApiSecretService($app['config']->get('api-secret'));
        });
    }

    protected function configPath()
    {
        return __DIR__ . '/config/api-secret.php';
    }

    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen');
    }

    protected function generateKey()
    {
        $config        = config('api-secret');
        $config['key'] = sha1(md5(mt_rand(10000, 99999)));

        $path = $this->configPath();

        $save_text = "<?php return " . var_export($config, true) . ";";

        if (fopen($path, 'w')) {
            file_put_contents($path, $save_text);
        } else {
            throw new InvalidConfigException('没有权限');
        }
    }
}
