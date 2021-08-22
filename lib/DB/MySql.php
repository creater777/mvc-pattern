<?php
namespace Lib\DB;

class MySql extends \RedBeanPHP\Facade implements DBInterface
{
    /**
     * @param array $config
     * @throws \RedBeanPHP\RedException
     */
    public function configure(array $config)
    {
        self::setup(
            "mysql:host={$config['host']};dbname={$config['database']}",
            $config['user'],
            $config['password'],
            $config['frozen'] ?: false,
            $config['partialBeans'] ?: false,
            $config['options'] ?: []
        );
        return self::testConnection();
    }
}