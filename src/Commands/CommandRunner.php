<?php
namespace Skmetaly\PopplerUtils\Commands;

use AdamBrett\ShellWrapper\Command as BaseCommand;
use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;
use Skmetaly\PopplerUtils\ConfigManager;

/**
 * Class Command
 * Wrapper over AdamBrett PHP Shell wrapper utilities
 *
 * @package Skmetaly\PopplerUtils
 */
class CommandRunner extends BaseCommand
{

    /**
     * @var bool
     */
    protected $captureStdErr = true;

    /**
     * @var ConfigManager
     */
    protected $config;

    /**
     * @var
     */
    protected $commandBuilder;

    /**
     * @var
     */
    protected $errors;

    /**
     *
     */
    public function __construct()
    {
        $this->shell = new Exec();
        $this->config = new ConfigManager();
    }

    /**
     * Creates the CommandBuilder and sets it for further use
     * @param $commandName
     */
    protected function createCommandBuilder($commandName)
    {
        $execCommand = $this->captureStdErr === true ? "$commandName 2>&1" : $commandName;
        $this->commandBuilder = new CommandBuilder($execCommand);
    }
    /**
     * @param Param $param
     *
     * @return $this
     */
    public function addParam($param)
    {
        if (is_string($param)) {
            $this->commandBuilder->addParam($param);
        }

        return $this;
    }

    /**
     * Runs the set command
     * and sets errors if status code is non zero ( error )
     * @return string
     */
    public function run()
    {
        $this->execute();

        if($this->getStatusCode() !==0){
            $this->setError($this->getLastOutuput());
        }

        return $this;
    }

    /**
     * Calls the shell runner to run the command
     * @return string
     */
    protected function execute()
    {
        return $this->shell->run($this->commandBuilder);
    }

    /**
     * Gets last output of the shell runner
     * @return mixed
     */
    public function getLastOutuput()
    {
        return $this->shell->getOutput();
    }

    /**
     * Gets the status code of the shell runner
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->shell->getReturnValue();
    }

    /**
     * Sets error output
     * @param $error
     */
    private function setError($error)
    {
        $this->errors = $error;
    }

    /**
     * Returns errors
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}