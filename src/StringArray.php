<?php

namespace ale\StringArray;

/**
 * Class StringArray
 * A simple implementation of a C-style array as a string.
 */
class StringArray
{

    /**
     * The width of the simulated array.
     *
     * This is not currently used actively, but might be handy (eg. in case we
     * want to initialize the whole string in advance.)
     *
     * @var int
     */
    private $width;

    /**
     * The height of the simulated array.
     *
     * @var int
     */
    private $height;

    /**
     * The size in bytes of each value in the array.
     *
     * @var int
     */
    private $cellSize;

    /**
     * Storage for the actual data.
     *
     * @var string
     */
    private $data = '';

    /**
     * A cache of the unprintable ASCII characters.
     *
     * @var array
     */
    private $unprintableChars = array();

    /**
     * The type of data this StringArray can handle.
     *
     * @var string
     */
    private $type = 'UINT32';

    /**
     * List of types supported by this class.
     *
     * @var array
     */
    private $types = array(
        'UINT32' => array('size' => 4, 'format' => 'L'),
        'DOUBLE' => array('size' => 8, 'format' => 'd'),
    );

    public function __construct($width, $height, $type = 'UINT32') {
        // @todo - handle type and cell size internally.

        // Initialize the string so that PHP won't think it's an array when we
        // start using offsets.
        $this->data = str_pad('', 1, chr(0));
        $this->width = $width;
        $this->height = $height;
        $this->type = $type;
        // @TODO - validate types.
        $this->cellSize = $this->types[$type]['size'];
    }

    /**
     * Inserts a value at the requested position.
     *
     * @param int $i
     *   The first dimension position to store the value.
     * @param int $j
     *   The second dimension position to store the value.
     * @param mixed $value
     *   The value to store.
     */
    public function insert($i, $j, $value) {
        // @todo - validate that the passed value fits in the dimensions.
        $index = $this->getIndex($i, $j);
        // @todo - generalise hardcoded type.
        $encoded = pack($this->types[$this->type]['format'], $value);
        // I think this is the fastest way to splice this value into storage,
        // but maybe worth checking.
        for ($i = 0; $i < $this->types[$this->type]['size']; ++$i) {
            $this->data[$index + $i] = $encoded[$i];
        }
    }

    /**
     * Retrieves a value from the given position.
     *
     * @param int $i
     *   The first dimension position to retrieve.
     * @param int $j
     *   the second dimension position to retrieve.
     * @return mixed
     *   The retrieved value.
     */
    public function retrieve($i, $j) {
        $index = $this->getIndex($i, $j);
        $encoded = substr($this->data, $index, $this->types[$this->type]['size']);
        // Appending "value" to the unpack format forces the result to be in the
        // returned array under that key.
        return unpack($this->types[$this->type]['format'] . 'value', $encoded)['value'];
    }

    /**
     * Gets an index into the storage string
     *
     * @param int $i
     *   The first dimension position.
     * @param int $j
     *   The second dimension position.
     * @return int
     *   The caluculated increment into the storage string.
     */
    private function getIndex($i, $j) {
        return ($i * $this->height + $j) * $this->cellSize;
    }

    /**
     * Dump the internal storage, replacing some unprintable characters.
     */
    public function dump() {
        // Set up the excluded characters list just once if it hasn't been set.
        if (empty($this->unprintableChars)) {
            for ($i = 0; $i <= 31; ++$i) {
                $this->unprintableChars[] = chr($i);
            }
        }
        return str_replace($this->unprintableChars, '*', $this->data);
    }

    /**
     * Gets the size of the internal storage of the array.
     *
     * @return int
     *   The size, in bytes, taken by the internal array storage.
     */
    public function size() {
        return strlen($this->data);
    }

}
