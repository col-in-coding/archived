<?php

class Log
{
    private $_Filename;
    private $_Data;

	/**
	 * Write to a file
	 * @param  str $filename  The name of the file
	 * @param  str $strData   Data to be appended to the file
	 * @return null
	 */
    public function write($filename, $strData)
    {
        // Set Class Vars
        $this->_Filename = $filename;
        $this->_Data = $strData;

    	// Check Data
        $this->_CheckPermission();
        $this->_CheckData(); 

        // Write to File
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
        $this->_Filename = $filename;
        $this->_CheckExists();

    	$handle = fopen($filename, "r");

    	return file_get_contents($filename);
    }

    private function _CheckPermission()
    {
        if (!is_writable($this->_Filename)) {
            die('Change your CHMOD permission to' . $this->_Filename);
        }
    }

    private function _CheckData()
    {
        if (strlen($this->_Data) < 1) {
            die('You must have at least one character.');
        }
    }

    private function _CheckExists()
    {
        if (!file_exists($this->_Filename)) {
            die('This file dose not exist');
        }
    }
}