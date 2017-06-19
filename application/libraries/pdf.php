<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	require_once APPPATH."/third_party/mpdf/mpdf.php";
	class pdf extends mPDF {
	    public function __construct() {
            error_reporting(0);
        ini_set('display_errors', 0);
	        parent::__construct();
	    }
	}
?>
