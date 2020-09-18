<?php

namespace App\FileLoader;

abstract class AbstractFileLoader
{
    protected $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    abstract public function load();
}