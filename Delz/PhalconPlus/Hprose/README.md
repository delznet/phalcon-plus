# hprose rpc演示

1.添加一个UserManager的服务，它有一个方法login

```
<?php
namespace Delz\PhalconPlus\Hprose\Demo;

/**
 * 这是一个测试用户服务
 *
 * @package Delz\PhalconPlus\Hprose\Demo
 */
class UserManager
{
    /**
     * 用户登录，不做任何业务处理，直接返回用户名和密码
     *
     * @param string $username
     * @param string $password
     * @return array
     */
    public function login($username, $password)
    {
        return [
            'username' => $username,
            'password' => $password
        ];
    }
}
```

2.添加此服务的服务提供者UserManagerProvider类

```
<?php

namespace Delz\PhalconPlus\Hprose\Demo;

use Delz\PhalconPlus\ServiceProvider\Provider as ServiceProvider;

/**
 * 用户服务提供者
 * @package Delz\PhalconPlus\Hprose\Demo
 */
class UserManagerProvider extends ServiceProvider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'user-manager';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new UserManager();
            }
        );
    }
}
```

3.将服务提供者注册到服务节点

```

[services]
user-manager = "Delz\PhalconPlus\Hprose\Demo\UserManagerProvider"
```

4.添加login的rpc服务提供者UserLoginRpcProvider类

```
<?php

namespace Delz\PhalconPlus\Hprose\Demo;

use Delz\PhalconPlus\Hprose\Provider;

/**
 * 用户登录rpc提供者
 *
 * @package Delz\PhalconPlus\Hprose\Demo
 */
class UserLoginRpcProvider extends Provider
{
    /**
     * rpc别名
     *
     * @var string
     */
    protected $name = 'login';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->server->addFunction(function ($username, $password) {
            /** @var UserManager $userManager */
            $userManager = $this->di->get('user-manager');
            return $userManager->login($username, $password);
        }, $this->name);
    }

}

```

5.将rpc服务提供者注册到配置服务rpc-services节点

```
[rpc-services]
login = "Delz\PhalconPlus\Hprose\Demo\UserLoginRpcProvider"
```

6.启动服务

```
<?php

use Delz\PhalconPlus\App\HproseHttpApp;

require __DIR__ . '/../vendor/autoload.php';


$app = new HproseHttpApp('test');
$app->run();
```

7.测试服务

```
<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Hprose\Http\Client('这里是rpc的网址', false);
print_r($client->login("11","12")) ;
```