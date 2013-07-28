<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of Cache
 *
 * @author alejandro
 */
class Cache {

    /**
     *
     * @var MemcacheManager Interacts and administrate PHP memcache object
     */
    private $memcacheManager = null;

    public function __construct() {
        global $CACHE_MANAGER;
        $this->memcacheManager = $CACHE_MANAGER;
    }

    /**
     * Retrieve cached data from memcached server
     *
     * @param string $key  Key of the value in cache to be retrieved
     * @return var
     */
    public function retrieve($key) {
        return ($this->memcacheManager) ? $this->memcacheManager->retrieve($key) : null;
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
        return ($this->memcacheManager) ? $this->memcacheManager->store($key, $data, $cacheTime) : false;
    }

    /**
     * Resets and clean the cache
     *
     */
    public function reset() {
        return $this->memcacheManager->reset();
    }

}
?>
