<?php
// +----------------------------------------------------------------------
// | InvalidConfigException.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/7/4 14:30
// +----------------------------------------------------------------------
// | Author: Felix <Fzhengpei@gmail.com>
// +----------------------------------------------------------------------

namespace Xinhaonaner\Secret\Exceptions;

use Throwable;

class InvalidConfigException extends Exception
{
    public function __construct($message = "参数有误", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}