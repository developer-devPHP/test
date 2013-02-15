<?php

class MyLib_Cache
{
    
    public function My_cache_set( $cache_name, $lang_short_name=null,$cache_status = false, $cache_array = NULL ){
        
        $frontendOptions = array(
                'lifetime' => 60 * 60 * 24, // one day
                'automatic_serialization' => true
        );
         
        $backendOptions = array('cache_dir' => MY_CACHE_DIRECTORY);
         
        $cache = Zend_Cache::factory('Core',
                'File',
                $frontendOptions,
                $backendOptions);
        // Delete OLD caches
        $cache->clean(Zend_Cache::CLEANING_MODE_OLD);
         
        /* SET Cache name START */
        $new_cache_name = "";
        if (empty($lang_short_name))
        {
            $new_cache_name = $cache_name;
        }
        else
        {
            $new_cache_name = $cache_name . $lang_short_name;
        }
        
        /* SET Cache name END */
        
        if (!($result = $cache->load($new_cache_name)))
        {
    
            if ($cache_status === true)
            {
                $cache->save($cache_array);
    
                $result = $cache->load($new_cache_name);
    
            }
            else
            {
                return true;
            }
        }
        else
        {
            $result = $cache->load($new_cache_name);
        }
    
        return $result;
         
    }
    public function My_cache_delete($cache_name, $lang_short_name=null)
    {
        $frontendOptions = array(
                'lifetime' => null,
                'automatic_serialization' => true
        );
        $backendOptions = array(
                'cache_dir' => MY_CACHE_DIRECTORY
        );
        /* SET Cache name START */
        $new_cache_name = "";
        if (empty($lang_short_name))
        {
            $new_cache_name = $cache_name;
        }
        else
        {
            $new_cache_name = $cache_name . $lang_short_name;
        }
        
        /* SET Cache name END */
        
        $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
    
    
        $cache->remove($new_cache_name);
    }
}