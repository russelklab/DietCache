<?php

class DietCache
{
    private $memcached = null;

    public function __construct($servers)
    {
        if (class_exists('Memcached')) {
            $this->memcached = new Memcached();
        } else {
            throw new Exception('No suitable cache library available');
        }

        $this->connect($servers);
    }

    /**
     * @param array $servers An array of servers for Memcached. Keys are host and port
     */
    private function connect(array $servers)
    {
        foreach($servers as $server) {

            $weight = 1;

            if(isset($server['weight'])) {
                $weight = $server['weight'];
            }

            $this->memcached->addServer($server['host'], $server['port'], $weight);
        }
    }

    /**
     * @return Memcached|null The memcached initiated class
     */
    public function getCache()
    {
        return $this->memcached;
    }

    /**
     * Store a new entry in the cache, if the already exists replace it with a new value
     *
     * @param $key
     * @param $value
     * @param null $expire
     * @return bool
     */
    public function add($key, $value, $expire = null)
    {
        $result = $this->memcached->add($key, $value, $expire);

        if($this->memcached->getResultCode() === Memcached::RES_NOTSTORED) {
            $result = $this->memcached->replace($key, $value, $expire);
        }

        return $result;
    }

    /**
     * @param String $key The key stored in cache to be retrieved
     * @return mixed The value of stored key
     */
    public function get($key)
    {
        return $this->memcached->get($key);
    }

    /**
     * @param String $key The key stored in cache to be deleted
     * @return bool Returns if success or failed
     */
    public function delete($key)
    {
        return $this->memcached->delete($key);
    }

    /**
     * Update a key in stored in cache if it already exists
     * or create a new key value pair if otherwise
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value, $expire = null)
    {
        return $this->memcached->set($key, $value, $expire);
    }
}