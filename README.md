# BlameLog
> Like Spotify Wrapped for bad code

Input your logfile and get an overview of the developers that created the most errors by using git-blame.

_Requires Git to be installed on your system._

## Usage
```php
$results = RLeroi\BlameLog\BlameLog::calculateTotals('/Users/rleroi/dev/my-project/storage/logs/laravel.log');
```
_This will take a while depending on the size of your log file._

This will return an array like this:
```php
[
    "R Leroi" => 185,
    "Someone Else" => 132,
    "Another Dev" => 33,
]
```

## Disclaimer
This package is made for _fun_ only, do not fire anyone. 😉