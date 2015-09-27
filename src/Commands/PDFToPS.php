<?php

namespace Skmetaly\PopplerUtils\Commands;


use AdamBrett\ShellWrapper\Command as BaseCommand;
use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

/**
 * Class PDFToPS
 * @package Skmetaly\PopplerUtils\Commands
 */
class PDFToPS extends CommandRunner
{

    /**
     * @var mixed
     */
    protected $commandName;

    /**
     *  Constructor
     */
    public function __construct()
    {
        parent::__construct();

        //  Create the command name for pdf to ps
        $this->commandName = $this->getCommandName();

        $this->createCommandBuilder($this->commandName);
    }

    /**
     *
     * @return mixed
     */
    private function getCommandName()
    {
        return $this->config->get('paths.pdftops');
    }

    /**
     * Generate Level 1 PostScript flag
     */
    public function generateLevel1()
    {
        $this->commandBuilder->addFlag('level1');
        return $this;
    }

    /**
     * Generate Level 2 PostScript flag
     */
    public function generateLevel2()
    {
        $this->commandBuilder->addFlag('level2');
        return $this;
    }

    /**
     * Generate Level 3 PostScript flag
     */
    public function generateLevel3()
    {
        $this->commandBuilder->addFlag('level3');
        return $this;
    }
}