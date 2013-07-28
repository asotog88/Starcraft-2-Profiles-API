<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of Utils
 *
 * @author alejandro.soto
 */
class Utils {

    /**
     * Converts a file to string
     * @param string $filename filename with absolute path
     * @return string
     */
    public static function fileToString($filename) {
        $contents = '';
        if (file_exists($filename)) {
            $handle = fopen($filename, "r");
            if (filesize($filename) > 0) {
                $contents = fread($handle, filesize($filename));
                fclose($handle);
            }
        }
        return $contents;
    }

    /**
     * Dump the contents of a variable, object, etc
     * @param var $variable Object, var, etc
     */
    public static function dump($variable) {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
    }

    /**
     * Creates a directory
     *
     * @param string $path Directory path
     */
    public static function createDir($path) {
        if (!file_exists($path)) {
            mkdir($path);
        }
    }

    /**
     * Converts an array into an object recursively
     *
     * @param array $array
     * @return object Object
     */
    public static function recursiveArrayToObject($array) {
        if (is_array($array)) {
            return (object) array_map('self::recursiveArrayToObject', $array);
        } else {
            return $array;
        }
    }

    /**
     * Merge array2 into array2 and replaces values when it finds the same keys
     * Alternative function to php core function called array_merge_recursive
     * because it works but has one problem, it merge but don't overwrites
     *
     * @param array $arr1
     * @param array $arr2
     */
    public static function mergeArrays($arr1, $arr2) {
        $keys = array_keys($arr2);
        foreach ($keys as $key) {
            if (isset($arr1[$key]) && is_array($arr1[$key]) && is_array($arr2[$key])) {
                $arr1[$key] = self::mergeArrays($arr1[$key], $arr2[$key]);
            } else {
                $arr1[$key] = $arr2[$key];
            }
        }
        return $arr1;
    }

    /**
     * Validates if a user agent is match the request user agent
     *
     * @param string $userAgent User agent to be compared against the request user agent
     * @return boolean True if is the same and False if not
     */
    public static function isUserAgentMatched($userAgent) {
        return (strpos($_SERVER['HTTP_USER_AGENT'], $userAgent) !== false);
    }

}
?>
