<?php
// +----------------------------------------------------------------------
// | HandleCheck.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/7/4 15:56
// +----------------------------------------------------------------------
// | Author: Felix <Fzhengpei@gmail.com>
// +----------------------------------------------------------------------

namespace Xinhaonaner\Secret;

use Xinhaonaner\Secret\Exceptions\InvalidConfigException;

class HandleCheck
{
    protected $apiSecret;

    protected $time;
    protected $parmas;
    protected $number;
    protected $signature;

    public function __construct(ApiSecretService $apiSecret)
    {
        $this->apiSecret = $apiSecret->options;
    }


    /**
     * @return bool
     */
    protected function isLumen()
    {
        return str_contains(app()->version(), 'Lumen');
    }

    /**
     * @function
     * @author Felix <Fzhengpei@gmail.com>
     * @return bool
     * @throws InvalidConfigException
     */
    public function check()
    {
        if (request()->isMethod('get')) {
            return true;
        }

        $this->time = request()->input('time');
        if ( !$this->time || (time() - $this->time) < $this->apiSecret['validate_time'] * 60) {
            throw new InvalidConfigException();
        }

        $this->number = request()->input('number');
        if ( !($this->number && is_numeric($this->number))) {
            throw new InvalidConfigException();
        }

        $this->signature = request()->input('signature');
        if ( !$this->signature) {
            throw new InvalidConfigException('缺少签名');
        }

        $this->parmas = ksort(request()->except('signature'));

        $this->signCheck();
    }

    /**
     * @function
     * @author Felix <Fzhengpei@gmail.com>
     * @throws InvalidConfigException
     */
    public function signCheck()
    {
        $sign = md5(md5($this->parmas) . $this->number . $this->apiSecret['key']);

        if ($sign != $this->signature) {
            throw new InvalidConfigException('签名有误');
        }
    }
}