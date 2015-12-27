Preport
=======

A simple PHP rule engine.

Usage
-----

### 1. Build reporter.

```php
use Preport\Reporter;

$reporter = new Reporter;

$reporter->report('too_short_input')
    ->where(function () use ($input) {
        return strlen($input) < 4;
    });

$reporter->report('too_long_input')
    ->where(function () use ($input) {
        return strlen($input) > 8;
    })
    ->unless('too_short_input');

$reporter->report('no_input')
    ->where(function () use ($input) {
        return !$input;
    });
    ->when('too_short_input');
```

### 2. Get reports.

```php
$reports = $reporter->walk();

foreach ($reports as $report) {
    $report->subject();
}
```

```
> $input = 'foo';
too_short_input

> $input = '';
too_short_input
no_input

> $input = 'foobarbaz';
too_long_input
```
