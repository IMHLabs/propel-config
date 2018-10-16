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
namespace PropelConfig\Configuration;

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
class Migration
{

    /**
     * Migration name
     *
     * @var string $name Namespace
     */
    protected $name = '';

    /*
     * Migration schema path
     *
     * @var string $schemaPath schema path
     */
    protected $schemaPath = '';

    /**
     * Migration config path
     *
     * @var string $configPath config path
     */
    protected $configPath = '';

    /**
     * Migration sql path
     *
     * @var string $sqlPath sql path
     */
    protected $sqlPath = '';

    /**
     * Migration migration path
     *
     * @var string $migrationPath migration path
     */
    protected $migrationPath = '';

    /**
     * Migration class path
     *
     * @var string $classPath class path
     */
    protected $classPath = '';

    /**
     * Set Migration name
     *
     * @param string $name Namespace
     *
     * @return PropelConfig\Configuration\Migration
     */
    public function setName(string $name): \PropelConfig\Configuration\Migration
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Migration name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set schema path
     *
     * @param string $schemaPath schema path
     *
     * @return PropelConfig\Configuration\Migration
     */
    public function setSchemaPath(string $schemaPath): \PropelConfig\Configuration\Migration
    {
        $this->schemaPath = $schemaPath;
        return $this;
    }

    /**
     * Get schema path
     *
     * @return string
     */
    public function getSchemaPath(): string
    {
        return $this->schemaPath;
    }

    /**
     * Set config path
     *
     * @param string $configPath config path
     *
     * @return PropelConfig\Configuration\Migration
     */
    public function setConfigPath(string $configPath): \PropelConfig\Configuration\Migration
    {
        $this->configPath = $configPath;
        return $this;
    }

    /**
     * Get config path
     *
     * @return string
     */
    public function getConfigPath(): string
    {
        return $this->configPath;
    }

    /**
     * Set sql path
     *
     * @param string $sqlPath sql path
     *
     * @return PropelConfig\Configuration\Migration
     */
    public function setSqlPath(string $sqlPath): \PropelConfig\Configuration\Migration
    {
        $this->sqlPath = $sqlPath;
        return $this;
    }

    /**
     * Get sql path
     *
     * @return string
     */
    public function getSqlPath(): string
    {
        return $this->sqlPath;
    }

    /**
     * Set migration path
     *
     * @param string $migrationPath migration path
     *
     * @return PropelConfig\Configuration\Migration
     */
    public function setMigrationPath(string $migrationPath): \PropelConfig\Configuration\Migration
    {
        $this->migrationPath = $migrationPath;
        return $this;
    }

    /**
     * Get migration path
     *
     * @return string
     */
    public function getMigrationPath(): string
    {
        return $this->migrationPath;
    }

    /**
     * Set class path
     *
     * @param string $classPath class path
     *
     * @return PropelConfig\Configuration\Migration
     */
    public function setClassPath(string $classPath): \PropelConfig\Configuration\Migration
    {
        $this->classPath = $classPath;
        return $this;
    }

    /**
     * Get class path
     *
     * @return string
     */
    public function getClassPath(): string
    {
        return $this->classPath;
    }

    /**
     * Get Migration Config Array
     *
     * @return array
     */
    public function getConfigArray(): array
    {
        return [
            'schema_path'    => $this->getSchemaPath(),
            'config_path'    => $this->getConfigPath(),
            'sql_path'       => $this->getSqlPath(),
            'migration_path' => $this->getMigrationPath(),
            'class_path'     => $this->getClassPath()
        ];
    }
}
