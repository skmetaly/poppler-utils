<?php

namespace Skmetaly\PopplerUtils;

use Skmetaly\PopplerUtils\Commands\PDFToPs;

/**
 * Class PDF
 * @package Skmetaly\PopplerUtils
 */
class PDF
{

    /**
     *  Exception message
     */
    const INVALID_FILENAME_EXCEPTION = 'Source filename could not be read';

    /**
     * @var the PDF filename
     */
    protected $filename;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param $filename
     * @param $options
     */
    public function __construct($filename = null, $options = null)
    {
        if ($filename) {
            $this->filename = $filename;
        }

        if ($options) {
            $this->options = $options;
        }

        $this->config = new ConfigManager();
    }


    /**
     * @param $filename
     */
    public function setFilename($filename)
    {
        if (!$this->validSourceFilename($filename)) {
            throw new \InvalidArgumentException();
        }

        $this->validateFilename($filename);
    }

    /**
     *
     * @param $outputFilepath
     *
     * @return bool
     */
    public function toPS($outputFilepath)
    {

        $command = new PDFToPs();

        $command = $command
                    ->addParam($this->filename)
                    ->addParam($outputFilepath);


        return $command;
    }

    /**
     * @param $commandName
     *
     * @return CommandRunner
     */
    protected function createCommand($commandName)
    {
        return new CommandRunner($commandName);
    }

    /**
     * @param $filename
     *
     * @return bool
     */
    protected function validSourceFilename($filename)
    {
        return is_string($filename) && file_exists($filename);
    }
}
