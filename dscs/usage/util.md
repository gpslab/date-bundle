# Util

[Bugfix](https://bugs.php.net/bug.php?id=63740) for get monday of this week

```php
use GpsLab\Bundle\DateBundle\Util;

// return 2015-07-06
$monday = Util::getMondayThisWeek(new \DateTime('2015-07-12'));
```

Round date. It can be useful for caching the SQL queries.

```php
// return 12:30:00
$date = Util::roundDate(new \DateTime('12:30:24', 60));
// return 12:31:00
$date = Util::roundDate(new \DateTime('12:30:54', 60));
// return 2016-12-07 12:00:00
$date = Util::roundDate(new \DateTime('2016-12-07 12:26:24', 3600));
// return 2016-12-08 00:00:00
$date = Util::roundDate(new \DateTime('2016-12-07 23:50:22', 3600));
```
