<?php

namespace PluginSettings;

trait Select {
    /** 
     * Get the settings option array and print one of its values
     */
    public function select($info)
    {
        $options = '';
        foreach ($info['options'] as $text) :
            $selected =-( $this->get_option( $info['field'] )  &&  esc_attr( $this->get_option( $info['field'] ) ) == $text) ? 'selected' : '';
            $options .= "<option value='{$text}' {$selected}>{$text}</option>";
        endforeach;

        printf(
            '<select id="%s" name="%s[%s]">%s</select>',
            $info['field'],
            $this->get_options_name(),
            $info['field'],
            $options
        );

    }

}