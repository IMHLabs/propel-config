<?php
/**
 *
 * Library to parsing of Propel configuration
 *
 * PHP Version: 5
 *
 * @category  InMotion
 * @package   PropelConfig
 * @author    IMH Development <development@inmotionhosting.com>
 * @copyright 2018 Copyright (c) InMotion Hosting
 * @license   https://inmotionhosting.com proprietary
 * @link      https://inmotionhosting.com
 */
namespace PropelConfig;

use PropelConfig\Configuration\Connection;
use PropelConfig\Configuration\Migration;

/**
 *
 * Library to parsing of Propel configuration
 *
 * PHP Version: 5
 *
 * @category  InMotion
 * @package   PropelConfig
 * @author    IMH Development <development@inmotionhosting.com>
 * @copyright 2018 Copyright (c) InMotion Hosting
 * @license   https://inmotionhosting.com proprietary
 * @link      https://inmotionhosting.com
 */
class Configuration
{

    /**
     * Connection and Migration config
     *
     * @var array $config Configuration Settings
     */
    protected $config = [
        'connections' => [],
        'migrations'  => []
    ];

    /**
     * Constructor
     *
     * @var array $options Options
     */
    public function __construct($options = [])
    {
        if (isset($options['configFile'])) {
            if ($fileName = realpath($options['configFile'])) {
                $config   = require $fileName;
                $this->parseConfigArray($config);
            }
        }
        $this->parseConfigArray($options);
    }

    /**
     * Parse Config Array
     *
     * @param array $config Configuration Options
     *
     * @return void
     */
    public function parseConfigArray($config)
    {
        $databaseConfig   = (@$config['database']) ?: [];
        $connectionConfig = (@$config['propel']['connections']) ?: [];
        $migrationConfig  = (@$config['propel']['migrations']) ?: [];
        $defaultSettings  = [
            'adapter'  => (@$databaseConfig['adapter']) ?: null,
            'host'     => (@$databaseConfig['params']['host']) ?: null,
            'username' => (@$databaseConfig['params']['username']) ?: null,
            'password' => (@$databaseConfig['params']['password']) ?: null,
            'dbname'   => (@$databaseConfig['params']['dbname']) ?: null,
            'charset'  => (@$databaseConfig['params']['charset'] ?: null)
        ];
        $this->parseConnectionConfig($defaultSettings);
        foreach ($connectionConfig as $namespace => $settings) {
            $settings['name'] = (@$settings['name']) ?: $namespace;
            $this->parseConnectionConfig($settings, $namespace);
        }
        foreach ($migrationConfig as $namespace => $settings) {
            $this->parseMigrationConfig($settings, $namespace);
        }
    }

    /**
     * Get Connection Config
     *
     * @param string $namespace Namespace
     *
     * @return array
     */
    public function getConnectionConfig($namespace = 'default'): array
    {
        $requestedConfig = $this->overrideConnectionConfig($namespace);
        return $requestedConfig->getConfigArray();
    }

    /**
     * Get Migration Config
     *
     * @param string $namespace Namespace
     *
     * @return array
     */
    public function getMigrationConfig($namespace): array
    {
        $requestedConfig = $this->overrideMigrationConfig($namespace);
        return $requestedConfig->getConfigArray();
    }

    /**
     * Get List of Namespaces
     *
     * @return array
     */
    public function getNamespaces(): array
    {
        $namespaces = array_keys($this->config['connections']);
        foreach ($namespaces as $index => $namespace) {
            if ($namespace == 'default') {
                unset($namespaces[$index]);
            }
            if ($namespace == '_') {
                unset($namespaces[$index]);
            }
        }
        return $namespaces;
    }

    /**
     * Get Dsn
     *
     * @param string $namespace Namespace
     *
     * @return string
     */
    public function getDsn($namespace): string
    {
        $requestedConfig = $this->overrideConnectionConfig($namespace);
        return $requestedConfig->getDsn();
    }

    /**
     * Get Configuration JSON, used for migrations
     *
     * @param string $namespace Namespace
     *
     * @return string
     */
    public function getJsonConfiguration($namespace): string
    {
        $requestedConfig = $this->overrideConnectionConfig($namespace);
        return $requestedConfig->getJsonConfiguration();
    }

    /**
     * Parse Connection Config
     *
     * @param array $config Configuration Options
     * @param string $namespace Namespace
     *
     * @return void
     */
    protected function parseConnectionConfig(array $config, string $namespace = 'default')
    {
        if (! isset($this->config['connections'][$namespace])) {
            if ($namespace != 'default') {
                if (array_key_exists('default', $this->config['connections'])) {
                    $this->config['connections'][$namespace] = clone $this->config['connections']['default'];
                } else {
                    $this->config['connections'][$namespace] = new Connection();
                }
            } else {
                $this->config['connections'][$namespace] = new Connection();
            }
        }
        foreach ($config as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'adapter':
                        $this->config['connections'][$namespace]->setHost($value);
                        break;
                    case 'name':
                        $this->config['connections'][$namespace]->setName($value);
                        break;
                    case 'host':
                        $this->config['connections'][$namespace]->setHost($value);
                        break;
                    case 'username':
                        $this->config['connections'][$namespace]->setUsername($value);
                        break;
                    case 'password':
                        $this->config['connections'][$namespace]->setPassword($value);
                        break;
                    case 'dbname':
                        $this->config['connections'][$namespace]->setDbname($value);
                        break;
                    case 'charset':
                        $this->config['connections'][$namespace]->setCharset($value);
                        break;
                    case 'queries':
                        $this->config['connections'][$namespace]->setQueries($value);
                        break;
                    case 'classname':
                        $this->config['connections'][$namespace]->setClassname($value);
                        break;
                }
            }
        }
    }

    /**
     * Parse Migration Config
     *
     * @param array $config Configuration Options
     * @param string $namespace Namespace
     *
     * @return void
     */
    protected function parseMigrationConfig(array $config, string $namespace = 'default')
    {
        if (! isset($this->config['migrations'][$namespace])) {
            if ($namespace != 'default') {
                if (array_key_exists('default', $this->config['migrations'])) {
                    $this->config['migrations'][$namespace] = clone $this->config['migrations']['default'];
                } else {
                    $this->config['migrations'][$namespace] = new Migration();
                }
            } else {
                $this->config['migrations'][$namespace] = new Migration();
            }
        }
        foreach ($config as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'schema_path':
                        $this->config['migrations'][$namespace]->setSchemaPath($value);
                        break;
                    case 'config_path':
                        $this->config['migrations'][$namespace]->setConfigPath($value);
                        break;
                    case 'sql_path':
                        $this->config['migrations'][$namespace]->setSqlPath($value);
                        break;
                    case 'migration_path':
                        $this->config['migrations'][$namespace]->setMigrationPath($value);
                        break;
                    case 'class_path':
                        $this->config['migrations'][$namespace]->setClassPath($value);
                        break;
                }
            }
        }
    }

    /**
     * Override Connection Config
     *
     * @param array $config Configuration Options
     * @param string $override Override
     *
     * @return Connection
     */
    protected function overrideConnectionConfig(string $namespace, string $override = '_'): Connection
    {
        if (array_key_exists($namespace, $this->config['connections'])) {
            $config = $this->config['connections'][$namespace];
        } elseif (array_key_exists('default', $this->config['connections'])) {
            $config = $this->config['connections']['default'];
        } else {
            $config = new Connection();
        }
        $requestedConfig = clone $config;
        if (array_key_exists($override, $this->config['connections'])) {
            $override = $this->config['connections'][$override];
            $requestedConfig->setName(($override->getName())           ?: $requestedConfig->getName());
            $requestedConfig->setAdapter(($override->getAdapter())     ?: $requestedConfig->getAdapter());
            $requestedConfig->setHost(($override->getHost())           ?: $requestedConfig->getHost());
            $requestedConfig->setUsername(($override->getUsername())   ?: $requestedConfig->getUsername());
            $requestedConfig->setPassword(($override->getPassword())   ?: $requestedConfig->getPassword());
            $requestedConfig->setDbname(($override->getDbname())       ?: $requestedConfig->getDbname());
            $requestedConfig->setCharset(($override->getCharset())     ?: $requestedConfig->getCharset());
            $requestedConfig->setQueries(($override->getQueries())     ?: $requestedConfig->getQueries());
            $requestedConfig->setClassname(($override->getClassname()) ?: $requestedConfig->getClassname());
        }
        return $requestedConfig;
    }

    /**
     * Override Migration Config
     *
     * @param array $config Configuration Options
     * @param string $override Override
     *
     * @return Migration
     */
    protected function overrideMigrationConfig(string $namespace, string $override = '_'): Migration
    {
        if (array_key_exists($namespace, $this->config['migrations'])) {
            $config = $this->config['migrations'][$namespace];
        } elseif (array_key_exists('default', $this->config['migrations'])) {
            $config = $this->config['migrations']['default'];
        } else {
            $config = new Migration();
        }
        $requestedConfig = clone $config;
        if (array_key_exists($override, $this->config['migrations'])) {
            $override = $this->config['migrations'][$override];
            $requestedConfig->setName(($override->getName())                   ?: $requestedConfig->getName());
            $requestedConfig->setSchemaPath(($override->getSchemaPath())       ?: $requestedConfig->getSchemaPath());
            $requestedConfig->setConfigPath(($override->getConfigPath())       ?: $requestedConfig->getConfigPath());
            $requestedConfig->setSqlPath(($override->getSqlPath())             ?: $requestedConfig->getSqlPath());
            $requestedConfig->setMigrationPath(($override->getMigrationPath()) ?: $requestedConfig->getMigrationPath());
            $requestedConfig->setClassPath(($override->getClassPath())         ?: $requestedConfig->getClassPath());
        }
        return $requestedConfig;
    }
}
