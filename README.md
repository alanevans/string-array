# string-array

[![Build Status](https://travis-ci.org/alanevans/string-array.svg?branch=master)](https://travis-ci.org/alanevans/string-array)
[![Code Coverage](https://scrutinizer-ci.com/g/alanevans/string-array/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alanevans/string-array/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alanevans/string-array/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alanevans/string-array/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alanevans/string-array/v/stable.svg)](https://packagist.org/packages/alanevans/string-array)
[![Total Downloads](https://poser.pugx.org/alanevans/string-array/downloads.svg)](https://packagist.org/packages/alanevans/string-array)
[![License](https://poser.pugx.org/alanevans/string-array/license.svg)](https://packagist.org/packages/alanevans/string-array)

This is an experimental library that intends to provide access to a C-like array
within PHP.  I cannot say whether this is a good idea or not, it mainly depends
on your use case.

The current implementation uses a PHP string to avoid the memory overhead of
using PHP's native hash table of Zvals to implement an array of arrays.  This
sacrifices speed for memory.

For even more (and slower) memory, you could consider shifting parts of the
string off into files.

As an informal example, a 10000x1000 StringArray (10,000,000 data cells) takes
about 40MB and takes about 10s to populate on an ok-ish laptop.  The same in
nested PHP arrays can be done in about half the time, but takes 1.4GB.  I can
easily test a StringArray of 10000x10000, which takes about 400MB, but it
becomes prohibitive to test that size of array with native PHP arrays.

The question might well be "what possible use case requires that much memory but
can afford to take that much time?"  Well, I leave that up to you.

## Installation

string-array can be installed with [Composer](http://getcomposer.org)
by adding it as a dependency to your project's composer.json file.

```json
{
    "require": {
        "ale/string-array": "*"
    }
}
```

Please refer to [Composer's documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction)
for more detailed installation and usage instructions.

## Usage

@todo

## TODO

I'm not sure when any of these will get done.

 - Testing
 - Currently, only 32-bit ints are handled.  More types should be possible, chars would be super easy.