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
class Connection
{

    /**
     * Connection name
     *
     * @var string $name Namespace
     */
    protected $name = '';

    /**
     * Connection adapter
     *
     * @var string $adapter adapter
     */
    protected $adapter = 'mysql';

    /**
     * Connection host
     *
     * @var string $host Connection host
     */
    protected $host = 'localhost';

    /**
     * Connection username
     *
     * @var string $username Connection username
     */
    protected $username = '';

    /**
     * Connection password
     *
     * @var string $password Connection password
     */
    protected $password = '';

    /**
     * Connection dbname
     *
     * @var string $dbname Connection dbname
     */
    protected $dbname = '';

    /**
     * Connection charset
     *
     * @var string $charset Connection charset
     */
    protected $charset = '';

    /**
     * Connection dsn
     *
     * @var string $dsn Connection dsn
     */
    protected $dsn = '';

    /**
     * Connection queries
     *
     * @var array $queries Connection queries
     */
    protected $queries = [
        'utf8' => 'SET NAMES utf8 COLLATE utf8_unicode_ci, COLLATION_CONNECTION = utf8_unicode_ci, COLLATION_DATABASE = utf8_unicode_ci, COLLATION_SERVER = utf8_unicode_ci'
    ];

    /**
     * Connection classname
     *
     * @var string $classname Connection classname
     */
    protected $classname = '\Propel\\Runtime\\Connection\\ConnectionWrapper';

    /**
     * Set Connection name
     *
     * @param string $name Namespace
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setName(string $name): \PropelConfig\Configuration\Connection
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Connection name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Connection adapter
     *
     * @param string $adapter adapter
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setAdapter(string $adapter): \PropelConfig\Configuration\Connection
    {
        switch ($adapter) {
            case 'pdo_mysql':
                $adapter = 'mysql';
                break;
            case 'pdo_sqlite':
                $adapter = 'sqlite';
                break;
            case 'pdo_pgsql':
                $adapter = 'pgsql';
                break;
        }
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * Get Connection adapter
     *
     * @return string
     */
    public function getAdapter(): string
    {
        return $this->adapter;
    }

    /**
     * Set Connection host
     *
     * @param string $host host
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setHost(string $host): \PropelConfig\Configuration\Connection
    {
        $this->host = $host;
        return $this;
    }

    /**
     * Get Connection host
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Set Connection username
     *
     * @param string $username username
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setUsername(string $username): \PropelConfig\Configuration\Connection
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get Connection username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set Connection password
     *
     * @param string $password password
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setPassword(string $password): \PropelConfig\Configuration\Connection
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get Connection password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set Connection dbname
     *
     * @param string $dbname dbname
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setDbname(string $dbname): \PropelConfig\Configuration\Connection
    {
        $this->dbname = $dbname;
        return $this;
    }

    /**
     * Get Connection dbname
     *
     * @return string
     */
    public function getDbname(): string
    {
        return $this->dbname;
    }

    /**
     * Set Connection charset
     *
     * @param string $charset charset
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setCharset(string $charset): \PropelConfig\Configuration\Connection
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * Get Connection charset
     *
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * Set Connection dsn
     *
     * @param string $dsn dsn
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setDsn(string $dsn): \PropelConfig\Configuration\Connection
    {
        $this->dsn = $dsn;
        return $this;
    }

    /**
     * Get Connection charset
     *
     * @return string
     */
    public function getDsn(): string
    {
        if ($this->dsn) {
            return $this->dsn;
        }
        switch ($this->getAdapter()) {
            case 'mysql':
                $this->dsn = sprintf(
                    "mysql:host=%s;dbname=%s;user=%s;password=%s", 
                    $this->getHost(), 
                    $this->getDbname(),
                    $this->getUsername(),
                    $this->getPassword()
                );
                break;
            case 'oci':
                $this->dsn = sprintf("oci:dbname=//%s/%s", $this->getHost(), $this->getDbname());
                break;
            case 'sqlite':
                $this->dsn = sprintf("sqlite:%s/%s", $this->getHost(), $this->getDbname());
                break;
            case 'pgsql':
                $this->dsn = sprintf(
                    "pgsql:host=%s;port=5432;dbname=%s;user=%s;password=%s", 
                    $this->getHost(), 
                    $this->getDbname(), 
                    $this->getUsername(), 
                    $this->getPassword()
                );
                break;
        }
        return $this->dsn;
    }

    /**
     * Set Connection queries
     *
     * @param array $queries queries
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setQueries(array $queries): \PropelConfig\Configuration\Connection
    {
        $this->queries = $queries;
        return $this;
    }

    /**
     * Get Connection queries
     *
     * @return string
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    /**
     * Set Connection classname
     *
     * @param string $classname classname
     *
     * @return \PropelConfig\Configuration\Connection
     */
    public function setClassname(string $classname): \PropelConfig\Configuration\Connection
    {
        $this->classname = $classname;
        return $this;
    }

    /**
     * Get Connection classname
     *
     * @return string
     */
    public function getClassname(): string
    {
        return $this->classname;
    }

    /**
     * Get Connection Config Array
     *
     * @return array
     */
    public function getConfigArray(): array
    {
        $connectionArray = [
            'name'      => $this->getName(),
            'adapter'   => $this->getAdapter(),
            'host'      => $this->getHost(),
            'username'  => $this->getUsername(),
            'password'  => $this->getPassword(),
            'dbname'    => $this->getDbname(),
            'charset'   => $this->getCharset(),
            'queries'   => $this->getQueries(),
            'classname' => $this->getClassname()
        ];
        // Strip empty values
        foreach ($connectionArray as $key => $value) {
            if ($key != 'password') {
                if (! $value) {
                    unset($connectionArray[$key]);
                }
            }
        }
        return $connectionArray;
    }

    /**
     * Get Configuration JSON
     *
     * @return string`
     */
    public function getJsonConfiguration(): string
    {
        $connectionConfig = $this->getConfigArray();
        $connection['propel']['database']['connections'][$connectionConfig['name']] = [
            'adapter'   => $connectionConfig['adapter'],
            'classname' => $connectionConfig['classname'],
            'user'      => $connectionConfig['username'],
            'password'  => $connectionConfig['password'],
            'dsn'       => $this->getDsn()
        ];
        if (@$connectionConfig['charset']) {
            $connection['propel']['database']['connections'][$connectionConfig['name']]['settings']['charset'] = $connectionConfig['charset'];
        }
        if (@$connectionConfig['queries']) {
            $connection['propel']['database']['connections'][$connectionConfig['name']]['settings']['queries'] = $connectionConfig['queries'];
        }
        $connection['propel']['runtime'] = [
            'defaultConnection' => $connectionConfig['name'],
            "connections" => [
                $connectionConfig['name']
            ]
        ];
        $connection['propel']['generator'] = [
            'defaultConnection' => $connectionConfig['name'],
            "connections" => [
                $connectionConfig['name']
            ]
        ];
        return json_encode($connection);
    }
}
