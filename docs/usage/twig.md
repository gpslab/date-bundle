Twig extension
==============

## Overridden filter

`date` filter is overridden and use a `Formatter::format()`.

```twig
{# return 'Июля' #}
{{ '2016-07-20' | date('f') }}
```

## New functions

Added functions for compare dates and times in Twig

```twig
{{ compare_date_time($x, '>', $y) }}
{{ compare_date($x, '>=', $y) }}
{{ compare_time($x, '<', $y) }}
{{ compare_week($x, '<=', $y) }}
{{ compare_month($x, '=', $y) }}
{{ compare_year($x, '!=', $y) }}
```
