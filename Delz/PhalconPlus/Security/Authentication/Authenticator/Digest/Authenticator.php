<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\Digest;

use Delz\PhalconPlus\Event\Manager as EventManager;
use Delz\PhalconPlus\Security\Authentication\Authenticator as BaseAuthenticator;
use Delz\PhalconPlus\Security\Authentication\IToken;
use Delz\PhalconPlus\Security\Authentication\ITokenStorage;
use Delz\PhalconPlus\Security\Exception\UnsupportedTokenException;
use Delz\PhalconPlus\Security\User\IUser;
use Delz\PhalconPlus\Security\User\IUserProvider;
use Phalcon\Http\RequestInterface;
use Delz\PhalconPlus\Security\Authentication\Authenticator\Digest\Token as DigestToken;
use Delz\PhalconPlus\Security\Exception\UnsupportedUserException;

/**
 * 摘要认证器
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\Digest
 */
class Authenticator extends BaseAuthenticator
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * header参数前缀
     *
     * 为了适应某些 PaaS 平台（如 SAE）过滤特定 HTTP Header 的机制而考虑的。
     *
     * @var string
     */
    protected $prefix = 'Dz-';

    /**
     * 签名有效时间，单位秒
     *
     * @var int
     */
    protected $lifetime = 30;

    /**
     * @param RequestInterface $request
     * @param string $prefix
     * @param IUserProvider $userProvider
     * @param ITokenStorage $tokenStorage
     * @param EventManager $eventManager
     */
    public function __construct(RequestInterface $request, string $prefix = null, IUserProvider $userProvider, ITokenStorage $tokenStorage, EventManager $eventManager)
    {
        $this->request = $request;
        $this->prefix = $prefix ? $prefix : $this->prefix;
        parent::__construct($userProvider, $tokenStorage, $eventManager);
    }

    /**
     * 设置lifetime
     *
     * @param int $lifetime
     */
    public function setLifeTime(int $lifetime)
    {
        $this->lifetime = $lifetime;
    }


    /**
     * {@inheritdoc}
     */
    protected function createToken(): ?IToken
    {
        $appId = $this->request->getHeader($this->getHeaderKey('App-Id'));
        $nonce = $this->request->getHeader($this->getHeaderKey('Nonce'));
        $timestamp = (int)$this->request->getHeader($this->getHeaderKey('Timestamp'));
        $signature = $this->request->getHeader($this->getHeaderKey('Signature'));

        if (!$appId || !$timestamp || !$nonce || !$signature) {
            return null;
        }

        if (abs($timestamp - time()) > $this->lifetime) {
            return null;
        }

        $isMaster = $this->request->getHeader($this->getHeaderKey('IsMaster'));
        $isMaster = ($isMaster === 0) ? false : true;

        return new DigestToken($appId, $nonce, $timestamp, $signature, $isMaster);
    }

    /**
     * {@inheritdoc}
     */
    protected function checkCredentials(IToken $token, IUser $user): bool
    {
        if (!$user instanceof IAppSecretUser) {
            throw  new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        if (!$token instanceof DigestToken) {
            throw new UnsupportedTokenException(
                sprintf('Instances of "%s" are not supported.', get_class($token))
            );
        }

        if ($token->isMaster()) {
            $signature = sha1($user->getAppMasterSecret() . $token->getNonce() . $token->getTimestamp());
        } else {
            $signature = sha1($user->getAppSecret() . $token->getNonce() . $token->getTimestamp());
        }


        return $signature === $token->getSignature();
    }

    /**
     * 获取header的key值
     *
     * @param string $key
     * @return string
     */
    private function getHeaderKey(string $key): string
    {
        return $this->prefix . $key;
    }

}