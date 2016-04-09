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

    public function __construct($width, $height, $cell_size = 4) {
        // @todo - handle type and cell size internally.

        // Initialize the string so that PHP won't think it's an array when we
        // start using offsets.
        $this->data = str_pad('', 1, chr(0));
        $this->width = $width;
        $this->height = $height;
        $this->cellSize = $cell_size;
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
        $encoded = pack('L', $value);
        // I think this is the fastest way to splice this value into storage,
        // but maybe worth checking.
        $this->data[$index] = $encoded[0];
        $this->data[$index + 1] = $encoded[1];
        $this->data[$index + 2] = $encoded[2];
        $this->data[$index + 3] = $encoded[3];
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
        $encoded = substr($this->data, $index, 4);
        return unpack('Lval', $encoded)['val'];
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

    public function dump() {
        var_dump(str_replace(chr(0), '*', $this->data));
    }

    public function size() {
        return strlen($this->data);
    }

}
