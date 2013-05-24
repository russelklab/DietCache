### DietCache - Simple Memcached wrapper

<p>Sample code</p>

<pre>
<code>
<?php
        // prepare an array of servers
        // with keys host and port
        $servers = array(
            array('host' => '127.0.0.1', 'port' => '11211')
        );

        $cache = new DietCache($servers);

        // create a new cache key value
        $cache->add('test1', 'test1');

        // or use set same as add
        $cache->set('test1', 'test1');

        // retrieve a key
        $cache->get('test1');

        // delete a key
        $cache->delete('test1');

</code>
</pre>


##### russel.baoy@klab.com