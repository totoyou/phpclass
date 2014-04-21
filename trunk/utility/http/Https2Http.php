<?php

/**
 * /Https2Http.php
 * $Date:: 2014-04-14 18:57:53 +0900 #$
 * @version $Rev: 3956 $
 * @package Https2Http
 */

namespace utility\http;

/**
 * Description of Https2Http
 * 
 * @package Https2Http
 */
class Https2Http
{

    /**
     * 
     * @param string $url
     * @return string
     */
    static public function removeS($url = '')
    {
        return str_replace('https://', 'http://', $url);
    }

    /**
     * 
     * @param string $url
     * @return string
     */
    static public function insertS($url = '')
    {
        return str_replace('http://', 'https://', $url);
    }

}
