Round date
==========

It can be useful for caching the SQL queries.

```php
// return 12:30:00
$date = RoundDate::round(new \DateTime('12:30:24', 60));

// return 12:31:00
$date = RoundDate::round(new \DateTime('12:30:34', 60));

// return 12:00:00
$date = RoundDate::floor(new \DateTime('12:36:24', 3600));

// return 2016-12-08 00:00:00
$date = RoundDate::ceil(new \DateTime('2016-12-07 23:24:22', 3600));
```
