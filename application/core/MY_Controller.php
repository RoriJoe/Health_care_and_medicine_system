<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
* @package		Controller - CIMasterArtcak
* @author		Felix - Artcak Media Digital
* @copyright	Copyright (c) 2014
* @link		http://artcak.com
* @since		Version 1.0
 * @description
 * Abstrack kelas MY_Controller dibuat untuk kustomisasi dari MX_Controller dalam hal
 * 1. Pemanggilan templating dengan fungsi Display
 * 2. Pergantian theme layout, partial theme dan script
 * 3. Setter Getter in PHP
 */
        
        
class MY_Controller extends MX_Controller {

    /*What string should be used to separate title segments sent via $this->template->title('Foo', 'Bar'); */

    private $data = array(
        
        'theme_folder' => 'newui',
        'theme_layout' => 'template_samples',
        'header' => 'lay-header/default',
        'top_navbar' =>'lay-top-navbar/navbar_samples',
        'script_header' =>'lay-scripts/header_samples',
        'script_footer' =>'lay-scripts/footer_samples',
        'left_sidebar' =>'lay-left-sidebar/default',
        'footer' =>'lay-footer/default'
        
    );
    
    /*
     * Setter dan Getter
     */
    function set_idModule()
    {
        $this->data['idModule']=$this->module_m->getModulebyCode($this->router->fetch_class());
    }
    
    
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    
    public function get($name)
    {
        if (array_key_exists($name, $this->data)) {
           return $this->data[$name];
        }
        else
        {
            echo 'error unset data '.$name;
        }
    }
    public function __isset($name) {
        return isset($this->data[$name]);
    }
    
    public function __unset($name) {
        unset($this->data[$name]);
    }
    
    /**
    * Construct dari My Controller
    * @package Controller
    * @todo finish Modules dan Permission
    */
   
   
    public function __construct() {
            parent::__construct();  
            date_default_timezone_set("Asia/Jakarta");
            //bug untuk form_validation
            $this->form_validation->CI =& $this; 
            
        }
        
        
        public function display($view_page,$content=array())
	{
            $content['nama']="Testing Admin";
            
            //nice to be able to set title right in the controller in one shot. 
            //Before using template, I had to keep passing the title value here and 
            //there till it reached the header where finally it could get echoed.
            $this->template->title("SIM Puskesmas & Obat | Pemkab Jember");

            //'default_theme' is a folder name.
            $this->template->set_theme($this->data['theme_folder']);

            //This layout file can use $template['variables'] to put your contents
            $this->template->set_layout($this->data['theme_layout']);

            //setting partials view. see the image above for header.php and footer.php locations.
            //these will be available in layout file as $template['partials']['header'] and 
            //$template['partials']['footer']
            $this->template->set_partial('header',$this->data['header'],$content);
            $this->template->set_partial('top_navbar',$this->data['top_navbar'],$content);
            $this->template->set_partial('script_header',$this->data['script_header'],$content);
            $this->template->set_partial('script_footer',$this->data['script_footer'],$content);
            $this->template->set_partial('left_sidebar',$this->data['left_sidebar'],$content);
            $this->template->set_partial('footer',$this->data['footer'],$content);
            
            //the main content view that contains about page's content. 
            //this will be available in layout file as $template['body']
            
            $res= $this->template->build($view_page,$content);
            return $res;    
            
	}
        
        
        
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */