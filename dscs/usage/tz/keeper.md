# TimeZone Keeper

Timezone Keeper is a service for get default/system timezone and get user timezone and date from it.

As a default used `ResolveAndKeep` timezone keeper, but you can override it and implement `KeeperInterface`. Default
timezone keeper use `CollectionResolver` service for get all available timezone resolvers and use it for get user
timezone. See [guide](resolver.md) how to create custom timezone resolver.

You can get timezone keeper from DI:

```php
$tz_keeper = $this->get('gpslab.date.tz.keeper');
```
