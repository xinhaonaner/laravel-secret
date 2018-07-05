<?php
// +----------------------------------------------------------------------
// | ApiSecretService.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/7/4 13:13
// +----------------------------------------------------------------------
// | Author: Felix <Fzhengpei@gmail.com>
// +----------------------------------------------------------------------

namespace Xinhaonaner\Secret;


class ApiSecretService
{
    public $options;


    public function __construct(array $options = array())
    {
        $this->options = $this->normalizeOptions($options);
    }

    private function normalizeOptions(array $options = array())
    {
        return [
            'open'          => $options['open'],
            'validate_time' => $options['validate_time'],
            'key'           => $options['key'],
        ];

    }

}