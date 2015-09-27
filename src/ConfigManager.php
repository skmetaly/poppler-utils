<?php

namespace Skmetaly\PopplerUtils;

/**
 * Class Config
 * Configuration manager
 */
class ConfigManager
{

    const CONFIG_PATH = '/config';

    /**
     * Configs array
     * @var
     */
    protected $configs;

    /**
     *  Default Constructor
     */
    public function __construct()
    {
    }

    public function get($config)
    {
        //  Break the config to get the segments and file
        $segments = explode('.', $config);
        $configFile = $segments[ 0 ];

        if (!$this->alreadyImported($configFile)) {

            $this->importConfig($segments[ 0 ]);
        }

        return $this->getConfigValue($segments);
    }

    /**
     * Import a configuration file
     *
     * @param $baseConfigFile
     *
     * @return mixed|string
     * @internal param $configFile
     *
     */
    protected function importConfig($baseConfigFile)
    {
        //  Build the configuration file
        $configFile = __DIR__ . self::CONFIG_PATH . '/' . $baseConfigFile . '.php';

        //  Check if the file exists, so we can import it
        if (file_exists($configFile)) {

            $configSource = require_once $configFile;

            if (is_array($configSource)) {

                $this->config[ $baseConfigFile ] = $configSource;
            }
        }
    }

    /**
     * @param $segments
     *
     * @return mixed
     */
    protected function getConfigValue($segments)
    {

        //  Check if a config exists for this segments
        if (!isset($this->config[ $segments[ 0 ] ])) {

            return null;
        }

        $configSource = $this->config[ $segments[ 0 ] ];

        //  Return the entire array if the the requested config is only the filename
        if (count($segments) > 1) {

            //  Try to find the config
            $segments = array_slice($segments, 1);

            foreach ($segments as $segment) {

                if (isset($configSource[ $segment ])) {

                    $configSource = $configSource[ $segment ];
                }
            }
        }

        return $configSource;
    }

    private function alreadyImported($configFile)
    {
        return (isset($this->config[ $configFile ])) ? true : false;
    }
}