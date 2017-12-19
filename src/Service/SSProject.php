<?php

namespace SilverStripe\SSPak\Service;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use SilverStripe\SSPak\Exception\SSProjectResolverException;
use Symfony\Component\Process\Process;

abstract class SSProject
{
    /**
     * @var string
     */
    private $target;

    public function __construct($targetPath)
    {
        $this->setTarget($targetPath);
    }

    /**
     * @param string $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Resolves a SSProject instance for the given directory
     *
     * @throws SSProjectResolverException
     *
     * @param string $target The target directory to resolve
     * @return SS2Project|SS3Project|SS4Project
     */
    public static function resolve($target)
    {
        $target = rtrim($target, '/\\');

        // @todo update for SSH connections
        if (!file_exists($target) || !is_dir($target))
        {
            throw new SSProjectResolverException(sprintf('Target path "%s" does not exist', $target));
        }
        try {
            $adapter = new Local($target);
        }  catch (\LogicException $e) {
            throw new SSProjectResolverException('Target path not resolvable');
        }
        $filesystem = new Filesystem($adapter);
        if ($filesystem->has('/sapphire')) {
            // SS 2.x
            return new SS2Project($target);
        } elseif ($filesystem->has('/framework')) {
            // SS 3.x
            return new SS3Project($target);
        } elseif ($filesystem->has('/vendor/silverstripe/framework')) {
            // SS 4.x
            return new SS4Project($target);
        } else {
            throw new SSProjectResolverException('Unable to resole SilverStripe project version');
        }
    }

    /**
     * @return array
     */
    public function getDBConfig()
    {
        $process = new Process(['bin/sniffer', $this->getTarget()]);
        $process->mustRun();
        $dbConfig = $process->getOutput();
        return unserialize($dbConfig);
    }
}
