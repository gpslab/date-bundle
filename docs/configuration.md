Configuration
=============

```yml
gps_lab_date:
    # Is not required
    # As a default uset timezone from date_default_timezone_get()
    time_zone: 'Europe/Moscow'

    # HTTP Cookie parameters for store user timezone
    cookie:

        # You can disable use cookie for store user timezone
        used: true

        # HTTP Cookie variable names
        # It's a default values
        name: '_time_zone_name'
        offset: '_time_zone_offset'
```
