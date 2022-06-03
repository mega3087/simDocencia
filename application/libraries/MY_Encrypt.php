<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
Copyright (c) 2010 Prateek Rungta

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

/**
* MY_Encrypt
* 
* Makes the encode and decode functions produce/use url-safe outputs/inputs
*
* @package      CodeIgniter
* @subpackage   Libraries
* @category     Encrypt
* @author       Prateek Rungta
* @license      http://www.opensource.org/licenses/mit-license.php MIT License
* @link         http://prateekrungta.com/bitsnpieces/codeigniter-libraries#encrypt
* @version      1.0
*/

class MY_Encrypt extends CI_Encrypt
{
	var $unsafe_chars = '+=/';
	var $urlsafe_replacements = '-_~';
	
	
	/**
	 * Encodes the string and returns a url-safe value.
	 *
	 * @access  public
	 * @param   string  the string to encode
	 * @param   string  the key to use for encryption
	 * @return  string  encrypted, url-safe string
	 */
	function encode($string, $key = '')
	{
		return strtr(parent::encode($string, $key), $this->unsafe_chars, $this->urlsafe_replacements);
	}
	  	
	// --------------------------------------------------------------------
	
	/**
	 * Decodes the string encoded using the above encode() method
	 *
	 * @access  public
	 * @param   string  encrypted, url-safe string
	 * @param   string  key used during encryption
	 * @return  string  original string
	 * @see     encode
	 */
	function decode($string, $key = '')
	{
		return parent::decode(strtr($string, $this->urlsafe_replacements, $this->unsafe_chars), $key);
	}

}

