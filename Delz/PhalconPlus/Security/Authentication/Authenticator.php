<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication;

use Delz\PhalconPlus\Security\Exception\AuthenticationException;
use Delz\PhalconPlus\Security\Exception\DisableException;
use Delz\PhalconPlus\Security\Exception\TokenNotCreatedException;
use Delz\PhalconPlus\Security\Exception\UserNotFoundException;
use Delz\PhalconPlus\Security\Exception\BadCredentialsException;
use Delz\PhalconPlus\Security\User\IUser;
use Delz\PhalconPlus\Security\User\IUserProvider;
use Delz\PhalconPlus\Event\Manager as EventManager;
use Delz\PhalconPlus\Security\Events as SecurityEvents;

/**
 * 认证器抽象类
 *
 * 实现了一种认证方式，如果不希望使用这种认证方式，可以直接实现
 * Delz\PhalconPlus\Security\Authentication接口。
 *
 * 认证步骤：
 *
 * 1、获取IToken
 *
 *    每个IAuthenticator必须对应一个IToken类型。
 *    通过调用createToken()创建一个IToken。
 *    由于我们做的大部分是http服务，IToken创建的数据可以从request服务中获取。
 *    检查request数据，如果不符合，抛出AuthenticationException。
 *
 * 2、根据IToken获取用户IUser
 *
 *    每个IAuthenticator必须对应一个IUserProvider。
 *    通过getUserProvider()方法获取到IUserProvider服务。
 *    getUser($token)方法通过调用getUserProvider()方法获取到IUserProvider服务，
 * 利用IUserProvider::find($identifier)获取用户信息，$identifier=IToken::getIdentifier()
 *    如果用户不存在，抛出UserNotFoundException；
 *    如果用户没有激活，抛出DisableException；
 *
 * 3. 检查认证信息是否一致
 *
 *    通过比较IToken和IUser，判断是否Credentials是否一致。
 *    不同的认证方法，认证方法不一样。
 *    认证失败，抛出BadCredentialsException。
 *    成功将IUser写入IToken，并设置IToken::authenticated设置为true，用ITokenStorage存入IToken。
 *
 * @package Delz\PhalconPlus\Security\Authentication
 */
abstract class Authenticator implements IAuthenticator
{
    /**
     * @var IUserProvider
     */
    protected $userProvider;

    /**
     * @var ITokenStorage
     */
    protected $tokenStorage;

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @param IUserProvider $userProvider
     * @param ITokenStorage $tokenStorage
     * @param EventManager $eventManager
     */
    public function __construct(IUserProvider $userProvider, ITokenStorage $tokenStorage, EventManager $eventManager)
    {
        $this->userProvider = $userProvider;
        $this->tokenStorage = $tokenStorage;
        $this->eventManager = $eventManager;
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        if (!$token = $this->createToken()) {
            $this->eventManager->fire(SecurityEvents::AUTHENTICATE_FAIL_CREATE_TOKEN, $token);
            throw $this->onCreateTokenException();
        }
        if (!$user = $this->getUser($token)) {
            $this->eventManager->fire(SecurityEvents::AUTHENTICATE_FAIL_USER_NOT_FOUND, $token);
            throw $this->onUserNotFoundException();
        }
        if (!$user->isEnabled()) {
            $this->eventManager->fire(SecurityEvents::AUTHENTICATE_FAIL_USER_DISABLED, $token);
            throw $this->onUserDisableException();
        }
        if (!$this->checkCredentials($token, $user)) {
            $this->eventManager->fire(SecurityEvents::AUTHENTICATE_FAIL_BAD_CREDENTIALS, $token);
            throw $this->onBadCredentialsException();
        }
        $this->onSuccess($token, $user);
        $this->eventManager->fire(SecurityEvents::AUTHENTICATE_SUCCESS, $token);
    }

    /**
     * 获取Token
     *
     * 如果失败，返回null
     *
     * @return IToken|null
     */
    abstract protected function createToken():?IToken;

    /**
     * 检查鉴权信息是否正确
     *
     * 如果鉴权通过返回true，否则false
     *
     * @param IToken $token
     * @param IUser $user
     * @return bool
     */
    abstract protected function checkCredentials(IToken $token, IUser $user):bool;

    /**
     * 根据token获取用户信息
     *
     * @param IToken $token
     * @return IUser|null
     */
    protected function getUser(IToken $token):?IUser
    {
        return $this->getUserProvider()->find($token->getIdentifier());
    }

    /**
     * 获取用户提供者服务
     *
     * @return IUserProvider
     */
    protected function getUserProvider()
    {
        return $this->userProvider;
    }

    /**
     * 创建token异常
     *
     * @return AuthenticationException
     */
    protected function onCreateTokenException()
    {
        return new TokenNotCreatedException();
    }

    /**
     * @return UserNotFoundException
     */
    protected function onUserNotFoundException()
    {
        return new UserNotFoundException();
    }

    /**
     * @return DisableException
     */
    protected function onUserDisableException()
    {
        return new DisableException();
    }

    /**
     * @return BadCredentialsException
     */
    protected function onBadCredentialsException()
    {
        return new BadCredentialsException();
    }

    /**
     * @param IToken $token
     * @param IUser $user
     */
    protected function onSuccess(IToken $token, IUser $user)
    {
        $token->setUser($user);
        $token->setAuthenticated(true);
        $this->tokenStorage->setToken($token);
    }

}