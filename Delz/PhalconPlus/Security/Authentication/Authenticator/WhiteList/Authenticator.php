<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList;

use Delz\PhalconPlus\Security\Authentication\IAuthenticator;
use Delz\PhalconPlus\Security\Exception\UnsupportedIpException;
use Delz\PhalconPlus\Util\Client;

/**
 * ip白名单认证器
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList
 */
class Authenticator implements IAuthenticator
{
    /**
     * @var IManager
     */
    protected $manager;

    /**
     * @param IManager $manager
     */
    public function __construct(IManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $ip = Client::ip();
        if(!$this->manager->check($ip)) {
            throw new UnsupportedIpException(
                sprintf('your ip:%s is not in the white list.', $ip)
            );
        }
    }

}