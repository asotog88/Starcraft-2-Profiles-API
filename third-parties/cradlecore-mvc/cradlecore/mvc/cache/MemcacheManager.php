<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../CradleCoreException.php');

/**
 * Description of MemcacheManager
 *
 * @author alejandro
 */
class MemcacheManager {

    /**
     *
     * @var Memcache Memcache instance
     */
    private $memcache;
    /**
     *
     * @var int Default value for cache time in seconds
     */
    private $defaultCacheTime = 3600;

    public function __construct() {

    }

    /**
     * Connects to a memcached server
     *
     * @param string $host Memcache server hostname
     * @param int $port Memcache server port
     * @return boolean True is if connection is successfully or false if not
     */
    public function connect($host = '127.0.0.1', $port = 11211) {
        if (class_exists('Memcache')) {
            $this->memcache = new Memcache();
            error_reporting(0);
            $connected = $this->memcache->connect($host, $port);
            error_reporting(E_ALL);
            if ($connected) {
                return true;
            }
            $this->memcache = NULL;
            CradleCoreException::MVC('Could not establish connection with memcached server.');
            return false;
        }
        $this->memcache = NULL;
        CradleCoreException::MVC('PHP Memcache extension is not enabled.');
        return false;
    }

    /**
     * Retrieve cached data from memcached server
     *
     * @param string $key  Key of the value in cache to be retrieved
     * @return var
     */
    public function retrieve($key) {
        if ($this->memcache !== NULL) {
            $value = $this->memcache->get($key);
            if ($value !== false) {
                return $value;
            }
        }    
        return null;
    }

    /**
     * Stores a value in memcached server
     *
     * @param string $key Key of the value in cache to be stored
     * @param var $data Data to be stored
     * @param int $cacheTime Cache time in seconds, 0 means never expires
     * @return True on success and false if not
     */
    public function store($key, $data, $cacheTime = -1) {
        if ($this->memcache !== NULL) {
            return $this->memcache->set($key, $data, MEMCACHE_COMPRESSED, ($cacheTime < 0) ? $this->defaultCacheTime : $cacheTime);
        }
        return NULL;
    }

    /**
     * Resets and clean the cache
     *
     */
    public function reset() {
        if ($this->memcache !== NULL) {
            return $this->memcache->flush();
        }
        return false;
    }

}
?>  
