<?php

namespace PropelConfig\Tests;

use PHPUnit\Framework\TestCase;
use PropelConfig\Configuration;

class ConfigurationTest extends TestCase
{
    protected $sampleConfiguration = [
        'database' => [
            'adapter' => 'pdo_mysql',
            'params'  => [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'test'
            ],
        ],
        'propel' => [
            'connections' => [
                'ns1'  => [
                    'adapter'       => 'pdo_pgsql',
                    'name'          => 'test',
                    'host'          => '127.0.0.1',
                    'username'      => 'test',
                    'password'      => 's3cr3t',
                    'dbname'          => 'test',
                ],
                'ns2'  => []
            ],
            'migrations' => [
                'ns1'  => [
                    'schema_path'       => __DIR__,
                    'config_path'       => __DIR__,
                    'sql_path'          => __DIR__ . '/data',
                    'migration_path'    => __DIR__ . '/data/migrations',
                    'class_path'        => __DIR__ . '/src',
                ],
                'ns2'  => [
                    'schema_path'       => __DIR__,
                    'config_path'       => __DIR__,
                    'sql_path'          => __DIR__ . '/data',
                    'migration_path'    => __DIR__ . '/data/migrations',
                    'class_path'        => __DIR__ . '/src',
                ]
            ]
        ]
    ];

    protected $sampleConfigurationWithOverride = [
        'database' => [
            'adapter' => 'pdo_mysql',
            'params'  => [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'test'
            ],
        ],
        'propel' => [
            'connections' => [
                'ns1'  => [
                    'adapter'       => 'pdo_pgsql',
                    'name'          => 'test',
                    'host'          => '127.0.0.1',
                    'username'      => 'test',
                    'password'      => 's3cr3t',
                    'dbname'          => 'test',
                ],
                'ns2'  => [],
                '_'      => [
                    'name'          => 'override',
                    'host'          => 'http://override',
                    'username'      => 'override_user',
                    'password'      => 'override_s3cr3t',
                    'dbname'          => 'override_db',
                ]
            ],
            'migrations' => [
                'ns1'  => [
                    'schema_path'       => __DIR__,
                    'config_path'       => __DIR__,
                    'sql_path'          => __DIR__ . '/data',
                    'migration_path'    => __DIR__ . '/data/migrations',
                    'class_path'        => __DIR__ . '/src',
                ],
                'ns2'  => [
                    'schema_path'       => __DIR__,
                    'config_path'       => __DIR__,
                    'sql_path'          => __DIR__ . '/data',
                    'migration_path'    => __DIR__ . '/data/migrations',
                    'class_path'        => __DIR__ . '/src',
                ],
                '_'      => [
                    'schema_path'       => 'override_schema',
                    'config_path'       => 'override_config',
                    'sql_path'          => 'override_sql',
                    'migration_path'    => 'override_migration',
                    'class_path'        => 'override_class',
                ]
            ]
        ]
    ];

    public function testCreateConfigurationFromArray()
    {
        $config = new Configuration($this->sampleConfiguration);
        $this->assertInstanceOf(\PropelConfig\Configuration::class, $config);
        $connectionConfig = $config->getConnectionConfig('default');
        $this->assertInternalType('array', $connectionConfig);
    }

    public function testCreateConfigurationFromFile()
    {
        $config = new Configuration([
            'configFile' => __DIR__ . '/../../config.php'
        ]);
        $this->assertInstanceOf(\PropelConfig\Configuration::class, $config);
        $connectionConfig = $config->getConnectionConfig('default');
        $this->assertInternalType('array', $connectionConfig);
    }
    
    public function testParseConfigurationArray()
    {
        $config = new Configuration();
        $this->assertInstanceOf(\PropelConfig\Configuration::class, $config);
        $config->parseConfigArray($this->sampleConfiguration);
        $connectionConfig = $config->getConnectionConfig('default');
        $this->assertInternalType('array', $connectionConfig);
        $this->assertEquals('mysql', $connectionConfig['adapter']);
    }

    public function testGetDefaultConnectionConfiguration()
    {
        $config = new Configuration($this->sampleConfiguration);
        $connectionConfig = $config->getConnectionConfig();
        $this->assertEquals('mysql', $connectionConfig['adapter']);
        $this->assertEquals('localhost', $connectionConfig['host']);
        $this->assertEquals('root', $connectionConfig['username']);
        $this->assertEquals('', $connectionConfig['password']);
        $this->assertEquals('test', $connectionConfig['dbname']);
        $this->assertEquals('\Propel\Runtime\Connection\ConnectionWrapper', $connectionConfig['classname']);
        $this->assertInternalType('array', $connectionConfig['queries']);
    }
    
    public function testGetNamespaceConnectionConfiguration()
    {
        $config = new Configuration($this->sampleConfiguration);
        $connectionConfig = $config->getConnectionConfig('ns1');
        $this->assertEquals('test', $connectionConfig['name']);
        $this->assertEquals('mysql', $connectionConfig['adapter']);
        $this->assertEquals('127.0.0.1', $connectionConfig['host']);
        $this->assertEquals('test', $connectionConfig['username']);
        $this->assertEquals('s3cr3t', $connectionConfig['password']);
        $this->assertEquals('test', $connectionConfig['dbname']);
        $this->assertEquals('\Propel\Runtime\Connection\ConnectionWrapper', $connectionConfig['classname']);
        $this->assertInternalType('array', $connectionConfig['queries']);
        $connectionConfig = $config->getConnectionConfig('ns2');
        $this->assertEquals('ns2', $connectionConfig['name']);
        $this->assertEquals('mysql', $connectionConfig['adapter']);
        $this->assertEquals('localhost', $connectionConfig['host']);
        $this->assertEquals('root', $connectionConfig['username']);
        $this->assertEquals('', $connectionConfig['password']);
        $this->assertEquals('test', $connectionConfig['dbname']);
        $this->assertEquals('\Propel\Runtime\Connection\ConnectionWrapper', $connectionConfig['classname']);
        $this->assertInternalType('array', $connectionConfig['queries']);
    }

    public function testGetMigrationConfiguration()
    {
        $config = new Configuration($this->sampleConfiguration);
        $migrationConfig = $config->getMigrationConfig('ns1');
        $this->assertInternalType('array', $migrationConfig);
        $this->assertArrayHasKey('schema_path', $migrationConfig);
        $this->assertArrayHasKey('config_path', $migrationConfig);
        $this->assertArrayHasKey('sql_path', $migrationConfig);
        $this->assertArrayHasKey('migration_path', $migrationConfig);
        $this->assertArrayHasKey('class_path', $migrationConfig);
    }
    
    public function testGetNamespaces()
    {
        $config = new Configuration($this->sampleConfiguration);
        $namespaces = $config->getNamespaces();
        $this->assertInternalType('array', $namespaces);
        $this->assertContains('ns1', $namespaces);
        $this->assertContains('ns2', $namespaces);
    }
    
    public function testGetDsn()
    {
        $config = new Configuration($this->sampleConfiguration);
        $dsn = $config->getDsn('ns1');
        $this->assertStringStartsWith('mysql', $dsn);
    }
    
    public function testGetJsonConfiguration()
    {
        $config = new Configuration($this->sampleConfiguration);
        $json = $config->getJsonConfiguration('ns1');
        $this->assertStringStartsWith('{"propel', $json);
    }
    
    public function testGetOverridenConnectionConfiguration()
    {
        $config = new Configuration($this->sampleConfigurationWithOverride);
        $connectionConfig = $config->getConnectionConfig('ns1');
        $this->assertEquals('override', $connectionConfig['name']);
        $this->assertEquals('mysql', $connectionConfig['adapter']);
        $this->assertEquals('http://override', $connectionConfig['host']);
        $this->assertEquals('override_user', $connectionConfig['username']);
        $this->assertEquals('override_s3cr3t', $connectionConfig['password']);
        $this->assertEquals('override_db', $connectionConfig['dbname']);
        $connectionConfig = $config->getConnectionConfig('ns2');
        $this->assertEquals('override', $connectionConfig['name']);
        $this->assertEquals('mysql', $connectionConfig['adapter']);
        $this->assertEquals('http://override', $connectionConfig['host']);
        $this->assertEquals('override_user', $connectionConfig['username']);
        $this->assertEquals('override_s3cr3t', $connectionConfig['password']);
        $this->assertEquals('override_db', $connectionConfig['dbname']);
    }
}
