Custom timezone resolver
========================

For add custom user timezone resolver you need create service and implement `ResolverInterface`. Example service for get timezone
for authorized user:

```php
namespace Acme\Bundle\DemoBundle\Date\TimeZone\Resolver;

use Acme\Bundle\DemoBundle\Entity\User;
use GpsLab\Bundle\DateBundle\TimeZone\Resolver\ResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserResolver implements ResolverInterface
{
    protected $storage;

    public function __construct(TokenStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function getUserTimeZone()
    {
        //
        if (
            ($token = $this->storage->getToken()) &&
            ($user = $token->getUser()) &&
            $user instanceof User &&
            $user->getTimezone()
        ) {
            return new \DateTimeZone($user->getTimezone());
        }

        return null;
    }
}
```

Configure tagged service

```yml
services:
    acme.demo.date.tz.resolver.user:
        class: Acme\Bundle\DemoBundle\Date\TimeZone\Resolver\UserResolver
        arguments: [ '@security.token_storage' ]
        tags:
            - { name: gpslab.date.tz.resolver, priority: 10 }
        public: false
```
