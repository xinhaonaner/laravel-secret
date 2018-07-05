<?php
// +----------------------------------------------------------------------
// | HandleApiSecret.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/7/4 15:32
// +----------------------------------------------------------------------
// | Author: Felix <Fzhengpei@gmail.com>
// +----------------------------------------------------------------------

namespace Xinhaonaner\Secret;

use Closure;

class HandleApiSecret
{
    protected $secret;

    public function __construct(ApiSecretService $apiSecret)
    {
        $this->secret = $apiSecret;
    }

    public function handle($request, Closure $next)
    {
        $handle = new HandleCheck($this->secret);
        $handle->check();

        return $next($request);
    }
}