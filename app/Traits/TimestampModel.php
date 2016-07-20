<?php

namespace App\Traits;

trait TimestampModel{


    /**
    * 获取当前时间
    *
    * @return int
    */
    public function freshTimestamp() {
        return time();
    }
    protected function getDateFormat()
    {
        return 'U';
    }
    /**
    * 避免转换时间戳为时间字符串
    *
    * @param DateTime|int $value
    * @return DateTime|int
    */
    public function fromDateTime($value) {
        return $value;
    }

}
