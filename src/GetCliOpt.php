<?php

namespace LogGen;

use Ulrichsg\Getopt\Getopt;
use Ulrichsg\Getopt\Option;


class GetCliOpt
{
    protected $input;

    public function __construct()
    {
        // Register possible input arguments.
        $this->handler = new Getopt(array(
            new Option('r', 'release', Getopt::OPTIONAL_ARGUMENT),
            new Option('f', 'from', Getopt::OPTIONAL_ARGUMENT),
            new Option('t', 'to', Getopt::OPTIONAL_ARGUMENT),
            new Option('b', 'break', Getopt::OPTIONAL_ARGUMENT),
        ));
    }

    public function setInput($input)
    {
        array_shift($input);
        $this->input = join(' ', $input);
    }





    /**
     * Parses the input and returns the Getopt handler.
     *
     * @return Getopt
     */
    public function parse()
    {
        $this->handler->parse($this->input);

        return $this->handler;
    }

}