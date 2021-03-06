<?php

namespace StringArray\Test;

use ale\StringArray\StringArray;

class StringArrayTest extends \PHPUnit_Framework_TestCase
{

  /**
   * The maximum unsigned 32-bit int value: 2^32 - 1
   */
  const UINT_32_MAX = 4294967295;

  /**
   * Test StringArray for 32-bit int values.
   */
  public function testStoreRetrieveUInt32()
  {
    $m = mt_rand(100, 200);
    $n = mt_rand(100, 200);

    // This array stores a nested array of values.
    $tmp = array();
    // Default type is UINT32.
    $a = new StringArray($m, $n);

    for ($i = 0; $i < $m; ++$i) {
      if (!isset($tmp[$i])) {
        $tmp[$i] = array();
      }
      for ($j = 0; $j < $n; ++$j) {
        $tmp[$i][$j] = mt_rand(0, self::UINT_32_MAX);
        $a->insert($i, $j, $tmp[$i][$j]);
      }
    }

    // Compare what we stored in the array to what we stored in StringArray.
    foreach ($tmp as $i => $line) {
      foreach ($line as $j => $cell) {
        $this->assertEquals($cell, $b = $a->retrieve($i, $j));
      }
    }
  }

  /**
   * Test StringArray for double values.
   *
   * @todo - do this properly with a datasource
   */
  public function testStoreRetrieveDouble()
  {
    $m = mt_rand(100, 200);
    $n = mt_rand(100, 200);

    // This array stores a nested array of values.
    $tmp = array();
    $a = new StringArray($m, $n, 'DOUBLE');

    for ($i = 0; $i < $m; ++$i) {
      if (!isset($tmp[$i])) {
        $tmp[$i] = array();
      }
      for ($j = 0; $j < $n; ++$j) {
        $tmp[$i][$j] =  (double) (mt_rand() . '.' . (mt_rand() / mt_getrandmax()));
        $a->insert($i, $j, $tmp[$i][$j]);
      }
    }

    // Compare what we stored in the array to what we stored in StringArray.
    foreach ($tmp as $i => $line) {
      foreach ($line as $j => $cell) {
        $this->assertEquals($cell, $b = $a->retrieve($i, $j));
      }
    }
  }
}
