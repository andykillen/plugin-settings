<?php

namespace PluginSettings;

trait Controller {
    use \PluginSettings\Textarea;
    use \PluginSettings\Text;
    use \PluginSettings\Select;
    use \PluginSettings\Settings;

    /**
     * The access rights needed to be able to see the menu item.
     */
    protected $access = 'manage_options';
    /**
     * the menu name shown.
     */
    protected $menu_name = '';
    /**
     * The <h1> title of the page and the <title>.
     */
    protected $title = "Plugin Settings";
    /**
     * the settings group name.
     */
    protected $settings_group;
    /**
     * The settings section.
     */
    protected $settings_section;
    /**
     * The admin page name used in the URL.
     */
    protected $admin_page_name;

    /**
     * The function used to hold the settings configuration of the
     * plugin.
     * 
     * @return array
     */
    protected function settings(){
        return [];
    }

    /**
     * @return void
     */
    public function init(){
        
        // setup menu page
        add_action( 'admin_menu', [ $this, 'menu' ] );
        add_action( 'admin_init', [ $this, 'page_init' ] );        
    }

     /**
     * Undocumented function
     *
     * @return void
     */
    public  function menu(){
        if(empty($this->menu_name)){
            $this->menu_name = $this->title;
        }

        add_options_page(
            $this->title, 
            $this->menu_name, 
            $this->access, 
            $this->admin_page_name, 
            [ $this, 'create_admin_page' ]
        );

    }

    public function create_admin_page()
    {
        // Set class property
        $this->load_options();
        ?>
        <div class="wrap">
            <h1><?php echo $this->title; ?></h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( $this->settings_group );
                do_settings_sections( $this->settings_section );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

     public function page_init(){
        
        register_setting(
            $this->settings_group, // Settings group
            $this->options_name, // Option name
            array( $this , 'sanitize' ) // Sanitize
        );        

        
        foreach ( $this->settings() as $section ) :
            error_log(print_r($section, true));
            add_settings_section(
                $section['section'],
                $section['info'],
                [$this, 'settings_section'],
                $this->admin_page_name
            );

            foreach($section['fields'] as $set) :
                error_log(print_r($set, true));
                $info = [];
                $info['field']=$set['id'];
                if(isset($set['options'])){
                    $info['options']=$set['options'];
                }

                // Making sure the method is in lowercase
                $method_to_use = strtolower($set['type']);
                // checking it exists
                if (! method_exists($this,$method_to_use)){
                     continue;
                }
                
                // adding field
                add_settings_field(
                    $set['id'], // ID
                    $set['label'], // Title 
                    [ $this , $method_to_use ], // Callback
                    $this->admin_page_name, // Page
                    $section['section'], // Section
                    $info
                );
            endforeach;

        endforeach;
    }    

    public function sanitize( $input )
    {

        foreach ( $this->settings()  as $set ) :
          $new_input[ $set['id'] ] = sanitize_text_field( $input[ $set['id'] ] );
        endforeach;

        return $new_input;
    }

   public function settings_section(){

   }
}