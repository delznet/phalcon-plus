<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Api;

/**
 * api将request转化成response输出
 *
 * @package Delz\PhalconPlus\Api
 */
interface IHandler
{
    /**
     * @param IRequest $request
     * @return IResponse
     */
    public function handle(IRequest $request): IResponse;
}