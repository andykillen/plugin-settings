<?php

namespace PluginSettings;

trait Textarea {
     /** 
     * Get the settings option array and print one of its values
     */
    public function textarea($info)
    {
        printf(
            '<textarea id="%s" name="%s[%s]" />%s</textarea>',
            $info['field'],
            $this->get_options_name(),
            $info['field'],
            ( $this->get_option( $info['field'] ) ) ? esc_attr( $this->get_option( $info['field'] ) ) : ''
        );
    }
}