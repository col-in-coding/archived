<?php

class Log
{
	/**
	 * Write to a file
	 * @param  str $filename  The name of the file
	 * @param  str $strData   Data to be appended to the file
	 * @return null
	 */
    public function write($filename, $strData)
    {
    	if (!is_writable($filename)) {
    		die('Change your CHMOD permission to' . $filename);
    	}

    	$handle = fopen($filename, 'a+');
    	fwrite($handle, "\r\n" . $strData);
    	fclose($handle);
    }

    /**
     * Read a file
     * @param  str $filename  The name of file
     * @return str  The file content
     */
    public function read($filename)
    {
    	$handle = fopen($filename, "r");

    	return file_get_contents($filename);
    }
}