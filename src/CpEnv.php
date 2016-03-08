<?php
namespace Serff\PhpciEnv;

use PHPCI\Builder;
use PHPCI\Model\Build;
use PHPCI\Plugin;

class CpEnv implements Plugin
{
    /**
     * @var \PHPCI\Builder
     */
    protected $phpci;

    /**
     * @var \PHPCI\Model\Build
     */
    protected $build;

    protected $directory;

    /**
     * @var string
     */
    protected $envFile;

    /**
     * Set up the plugin, configure options, etc.
     *
     * @param Builder $phpci
     * @param Build $build
     * @param array $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = [])
    {
        $path = $phpci->buildPath;
        $this->phpci = $phpci;
        $this->build = $build;
        $this->directory = isset($options['directory']) ? $options['directory'] : $path;

        if (array_key_exists('env-file', $options)) {
            $this->envFile = $options['env-file'];
        }

    }

    public function execute()
    {
        $destination = $this->directory . DIRECTORY_SEPARATOR . '.env';

        if (file_exists($this->envFile)) {
            copy($this->envFile, $destination);
        }

        if (file_exists($destination)) {
            return true;
        }

        return false;
    }
}