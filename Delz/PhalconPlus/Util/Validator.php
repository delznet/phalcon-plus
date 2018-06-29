<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Util;

/**
 * 验证工具类
 *
 * @package Delz\Common\Util
 */
class Validator
{
    /**
     * 邮箱验证
     *
     * @param string $value
     * @return bool
     */
    public static function email(string $value):bool
    {
        $value = (string)$value;
        $valid = filter_var($value, FILTER_VALIDATE_EMAIL);
        return $valid !== false;
    }

    /**
     * 网址验证
     *
     * @param string $value
     * @return bool
     */
    public static function url(string $value):bool
    {
        $value = (string)$value;
        $valid = filter_var($value, FILTER_VALIDATE_URL);
        return $valid !== false;
    }

    /**
     * ip验证
     *
     * @param string $value
     * @return bool
     */
    public static function ip(string $value):bool
    {
        $value = (string)$value;
        $valid = filter_var($value, FILTER_VALIDATE_IP);
        return $valid !== false;
    }

    /**
     * ipv4验证
     *
     * @param string $value
     * @return bool
     */
    public static function ipv4(string $value):bool
    {
        $value = (string)$value;
        $valid = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        return $valid !== false;
    }

    /**
     * ipv4验证
     *
     * @param string $value
     * @return bool
     */
    public static function ipv6(string $value):bool
    {
        $value = (string)$value;
        $valid = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
        return $valid !== false;
    }

    /**
     * tcp/ip端口号验证
     *
     * @param int $value
     * @return bool
     */
    public static function port($value):bool
    {
        return static::integer($value) && $value >= 0 && $value < 65536;
    }

    /**
     * 验证手机号码(仅支持中国大陆地区)
     *
     * @param string $value
     * @return bool
     */
    public static function mobile(string $value):bool
    {
        $value = (string)$value;
        return !!preg_match('#^13[\d]{9}$|^17[0-9]\d{8}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $value);
    }

    /**
     * 验证是否数字
     *
     * @param string $value
     * @return bool
     */
    public static function numbers($value):bool
    {
        return !!preg_match('/^(\d+,?)*\d+$/', $value);
    }

    /**
     * 验证是否电话号码
     *
     * @param string $value
     * @return bool
     */
    public static function phone(string $value):bool
    {
        return !!preg_match('/^(\d{4}-|\d{3}-)?(\d{8}|\d{7})$/', $value);
    }

    /**
     * 验证是否日期
     *
     * @param string $value
     * @return bool
     */
    public static function date(string $value):bool
    {
        return !!preg_match('/^(\d{4}|\d{2})-((0?([1-9]))|(1[0-2]))-((0?[1-9])|([12]([0-9]))|(3[0|1]))$/', $value);
    }

    /**
     * 验证是否qq
     *
     * @param string $value
     * @return bool
     */
    public static function qq(string $value):bool
    {
        return !!preg_match('/^[1-9]\d{4,}$/', $value);
    }

    /**
     * 验证是否整数
     *
     * @param string $value
     * @return bool
     */
    public static function integer(string $value):bool
    {
        return !!preg_match('/^[+-]?\d{1,9}$/', $value);
    }

    /**
     * 验证是否浮点数
     *
     * @param string $value
     * @return bool
     */
    public static function float(string $value):bool
    {
        return !!preg_match('/^(([+-]?[1-9]{1}\d*)|([+-]?[0]{1}))(\.(\d){1,2})?$/i', $value);
    }

    /**
     * 验证是否日期和时间
     *
     * @param string $value
     * @return bool
     */
    public static function dateTime(string $value):bool
    {
        return !!preg_match('/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/', $value);
    }

    /**
     * 验证是否网站
     *
     * @param string $value
     * @return bool
     */
    public static function site(string $value):bool
    {
        return !!preg_match('/^(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?$/', $value);
    }

    /**
     * 验证字符串中是否含有汉字
     *
     * 字符串编码仅支持UTF-8
     *
     * @param string $value
     * @return bool
     */
    public static function chinese(string $value):bool
    {
        $value = (string)$value;
        return !!preg_match('~[\x{4e00}-\x{9fa5}]+~u', $value);
    }

    /**
     * 身份证验证包括一二代身份证
     *
     * @param string $value 需要验证的字符串
     * @return bool
     */
    public static function id(string $value):bool
    {
        return !!preg_match('/^\d{15}(\d{2}[0-9x])?$/i', $value);
    }

    /**
     * 邮政编码验证
     *
     * 此邮编验证只适合中国
     *
     * @param string $value 需要验证的字符串
     * @return bool
     */
    public static function zip(string $value):bool
    {
        return !!preg_match('/^\d{6}$/i', $value);
    }

    /**
     * 判断字符串是否为空
     *
     * @param string $value 需要验证的字符串
     * @return bool
     */
    public static function required(string $value):bool
    {
        return !!preg_match('/\S+/i', $value);
    }

    /**
     * 验证字符串的长度，判定长度是否在给定的$min到$max之间的长度。
     *
     * @param string $value 要验证的内容
     * @param int $min 最小值或最小长度
     * @param int $max 最大值或最大长度
     * @return bool
     */
    public static function length(string $value, int $min, int $max):bool
    {
        $value = (string)$value;
        $length = Str::length($value);
        return $length >= $min && $length <= $max;
    }

    /**
     * 验证用户名是否合法
     *
     * @param string $value
     * @param int $minLength 最小长度
     * @param int $maxLength 最大长度
     * @return bool
     */
    public static function username(string $value, int $minLength = 5, int $maxLength = 20):bool
    {
        return (bool)preg_match("!^[_a-zA-Z0-9\\x{4e00}-\\x{9fa5}]{" . $minLength . "," . $maxLength . "}$!u", $value);
    }
}