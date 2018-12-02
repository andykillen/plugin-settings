<?php
namespace PluginSettings;

trait Settings {
    protected $options = false;
    protected $options_name;

    public function load_options(){
        if($this->options == false ) {    
            $this->options = get_option($this->options_name);
        }
    }

    public function get_options(){
        if($this->options == false ){
            $this->load_options();
        }
        return $this->options;
    }

    public function get_option($key){
        if($this->options == false ){
            $this->load_options();
        }
        if(isset($this->options[$key])) {
            return $this->options[$key];
        }
        else return FALSE;
    }

    public function get_options_name(){
        return $this->options_name;
    }

   

}