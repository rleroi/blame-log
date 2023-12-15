# BlameLog
__Like Spotify Wrapped for bad code__

BlameLog is a tool that provides a Spotify Wrapped-style overview of developers responsible for the most errors in your codebase using git-blame.

_Requires Git to be installed on your system._

## Usage
```php
use RLeroi\BlameLog\BlameLog;

$results = BlameLog::calculateTotals('/Users/rleroi/dev/my-project/storage/logs/laravel.log');

```
_Note: This operation may take a while, depending on the size of your log file._

The method returns an array representing the developers and their respective error counts:
```php
[
    "R Leroi" => 185,
    "K Reeves" => 132,
    "Randy Marsh" => 33,
]
```

## Disclaimer
This package is intended for _fun_ purposes only. Please refrain from using it to make employment decisions. 😉