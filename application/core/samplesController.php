<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

/* controller di setiap modul dapat extends pada controller admin. Berfungsi untuk membatasi hak akses*/
class samplesController extends MY_Controller{
    function __construct() {
        
        parent::__construct();
        $this->theme_folder='newui';
    }   
}
?>
