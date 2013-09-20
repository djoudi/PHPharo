<?php

/**
 * PHP Pharaoh 'PHPharo'
 * PHPharo is a full featured oop non-mvc modular framework that
 * helps you create any type of app(s)
 * it`s very fast light
 * @license GPL-V3
 * @author PHPharo | Mohammed Abdullah Al-Ashaal
 * @link <https://twitter.com/phpharo> <PHPharo@Gmail.Com>
 * @copyright 2013
 */

/* ------------------------------------------------------------- */

/**
 * dbr
 * Database Array Based
 * @author PHPharo
 * @copyright 2013
 * @access public
 */
class dbr
{
    private static $file = null;


    /**
     * dbr::check()
     * 
     * @return void
     */
    private static function check()
    {
        (!file_exists(self::$file) || empty(self::$file)) ? die('<h1>You did not set the DB file yet</h1>') :
            '';
        (!is_writable(self::$file)) ? chmod(self::$file, 0777) : '';
        (!is_writable(self::$file)) ? die('<h1>Chmod the  ('.self::$file.') from ftp to 777</h1>') : '';
    }

    /**
     * dbr::config()
     * 
     * @param mixed $file_path
     * @return void
     */
    public static function config($file_path)
    {
        (file_exists($file_path)) ? self::$file = $file_path : die('file not found');
    }

    /**
     * dbr::get()
     * 
     * @param string $get
     * @return
     */
    public static function get($get = '*')
    {
        self::check();
        $r = file_get_contents(self::$file);
        (empty($r) || $r == '' ) ? $r = serialize(array()) : '';
        $r = unserialize($r);
        if ($get == '*')
        {
            return $r;
        } else
        {
            if(isset($r[$get])) 
                return $r[$get];
            else 
                return false;
        }
    }

    /**
     * dbr::set()
     * 
     * @param mixed $key
     * @param mixed $value
     * @return
     */
    public static function set($key, $value)
    {
        self::check();
        $all = self::get();
        $all[$key] = $value;
        $all = serialize($all);
        
        return file_put_contents(self::$file,$all);
    }
    
    /**
     * dbr::delete()
     * 
     * @param mixed $key
     * @return
     */
    public static function delete($key)
    {
        self::check();
        $all = self::get();
        if(isset($all[$key])) {
            unset($all[$key]);
            $all = serialize($all);
            
            return file_put_contents(self::$file,$all);
        } else 
            return false;
        
    }

}
