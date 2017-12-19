<?php

namespace SilverStripe\SSPak\Console;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    private $basePath;

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
        return $this;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }
}
