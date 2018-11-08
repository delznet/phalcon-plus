<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\User;

/**
 * 实现了ICredentialsHolder接口的trait
 *
 * @package Delz\PhalconPlus\Security\User
 */
trait TCredentialsHolder
{
    /**
     * 密码明文
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * 加密过的密码
     *
     * @Column("column"="password",type="string",length=255, nullable=false)
     * @var string
     */
    protected $password;

    /**
     * 盐值
     *
     * @Column("column"="salt",type="string",length=10, nullable=false)
     * @var string
     */
    protected $salt;

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt(?string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}