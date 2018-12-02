<?php

namespace PluginSettings;

trait Text {
    
    public function text($info)
    {
        printf(
            '<input type="text" id="%s" name="%s[%s]" value="%s" />',
            $info['field'],
            $this->get_options_name(),
            $info['field'],
            ( $this->get_option( $info['field'] ) ) ? esc_attr( $this->get_option( $info['field'] ) ) : ''
        );
    }
}