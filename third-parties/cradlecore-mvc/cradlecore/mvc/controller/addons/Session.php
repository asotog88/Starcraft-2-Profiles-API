<?php

/*
 * This file is part of the Cradlecore MVC package.
 * (c) Alejandro Soto Gonzalez. <asotog88@yahoo.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * Description of Session
 *
 * @author alejandro
 */
class Session {

    public function  __construct() {}
	
	/**
	 * Stores a value in session
	 * 
	 * @param String $key Unique key to identify the value in session
	 * @param object $value Value to be stored
	 */
	public function setValue($key, $value) {
		$_SESSION[$key] = $value;
	}
	
	/**
	 * Retrieves a value from session
	 * 
	 * @param String $key
	 * @return object Could be return the value stored or null if value no longer exists
	 */
	public function getValue($key) {
		return (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
	}
	
	/**
	 * Remove a value stored in session
	 * 
	 * @param String $key
	 */
	public function removeValue($key) {
		$_SESSION[$key] = null;
	}

}
?>