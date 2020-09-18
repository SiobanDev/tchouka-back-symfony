<?php

namespace App\FileLoader;

class JsonFileLoader extends AbstractFileLoader
{
    /**
     * Loads JSON file and decodes it
     *
     * @return void
     */
    public function load()
    {
        $content = file_get_contents($this->file);
        return json_decode($content, true);
    }
}