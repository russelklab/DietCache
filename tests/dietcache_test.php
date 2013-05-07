<?php

require_once __DIR__.'/../DietCache.php';

class DietCacheTest extends PHPUnit_Framework_TestCase
{

    public function testDietCache()
    {
        $servers = array(
            array('host' => '127.0.0.1', 'port' => '11211')
        );

        $cache = new DietCache($servers);
        $this->assertEquals(get_class($cache->getCache()), 'Memcached');

        $cache->add('test1', 'test1');
        $test1 = $cache->get('test1');

        $this->assertEquals($test1, 'test1');

        //replace test1 with another value
        $cache->add('test1', 'test2');
        $test2 = $cache->get('test1');
        $this->assertNotEquals($test1, $test2);
        $this->assertEquals($test2, 'test2');

        $delete = $cache->delete('test1');

        $this->assertTrue($delete);

        $test3 = $cache->get('test1');
        $this->assertFalse($test3);

    }
}
