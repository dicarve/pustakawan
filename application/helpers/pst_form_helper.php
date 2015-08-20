<?php
/**
 *
 * Copyright (C) 2014  Arie Nugraha (dicarve@gmail.com)
 *
 * Form element creator
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

function text_input($subtype = 'text', $name, $classes = '', $state = '', $default_value = '', $additional_attributes = '') {
  $output = '';
  $output .= '<input type="'.$subtype.'"';
  $output .= ' name="'.$name.'" id="'.$name.'"';
  if ($classes) {
    $output .= ' class="'.( !in_array($subtype, array('submit', 'button'))?'form-control ':'' ).'input-'.$subtype.' '.$classes.'"';  
  } else {
    $output .= ' class="'.( !in_array($subtype, array('submit', 'button'))?'form-control ':'' ).'input-'.$subtype.'"';
  }
  if ($default_value) {
    $output .= ' value="'.$default_value.'"';
  }
  if ($additional_attributes) {
    $output .= ' '.$additional_attributes;
  }
  $output .= '/>';
  return $output;
}

function textarea_input($name, $classes = '', $state = '', $default_value = '', $additional_attributes = '') {
  $output = '';
  $output .= '<textarea ';
  $output .= ' name="'.$name.'" id="'.$name.'"';
  if ($classes) {
    $output .= ' class="form-control input-textarea '.$classes.'"';  
  } else {
    $output .= ' class="form-control input-textarea"';
  }
  if ($additional_attributes) {
    $output .= ' '.$additional_attributes;
  }
  $output .= '>';
  if ($default_value) {
    $output .= $default_value;
  }
  $output .= '</textarea>';
  return $output;
}

function select_input($name, $options = array(), $classes = '', $state = '', $default_value = '', $additional_attributes = '') {
  $output = '';
  $output .= '<select ';
  $output .= ' name="'.$name.'" id="'.$name.'"';
  if ($classes) {
    $output .= ' class="form-control input-select '.$classes.'"';  
  } else {
    $output .= ' class="form-control input-select"';
  }
  if ($additional_attributes) {
    $output .= ' '.$additional_attributes;
  }
  $output .= '>';
  if ($options) {
    foreach ($options as $val => $text) {
      $selected = '';
      if ($default_value && ($default_value == $val)) {
        $selected = ' selected';
      }
      if (is_array($default_value) && in_array($val, $default_value)) {
        $selected = ' selected';
      }
      $output .= '<option value="'.$val.'"'.$selected.'>'.$text.'</option>';
    }
  }
  $output .= '</select>';
  return $output;
}

function checkbox_input($options = array(), $default_value = '') {
  $output = '';
  if ($options) {
    foreach ($options as $chbox) {
      $output .= '<label class="checkbox-label"><input type="checkbox"';
      $output .= ' name="'.$chbox['name'].'" id="'.$chbox['name'].'"';
      if ($classes) {
        $output .= ' class="form-control input-checkbox '.$chbox['classes'].'"';  
      } else {
        $output .= ' class="form-control input-checkbox"';
      }
      if ($default_value) {
        $output .= ' value="'.$chbox['value'].'"';
      }
      if ($additional_attributes) {
        $output .= ' '.$chbox['additional_attributes'];
      }
      if ($default_value && ($default_value == $chbox['value'])) {
        $output .= ' checked';
      }
      $output .= '/> '.$chbox['text'].'</label>';
    }
  }
  return $output;
}

function radio_input($options = array(), $name, $default_value = '') {
  $output = '';
  if ($options) {
    $r = 1;
    foreach ($options as $radio) {
      $output .= '<label class="label-radio"><input type="radio"';
      $output .= ' name="'.$name.'" id="'.$name.$r.'"';
      if ($classes) {
        $output .= ' class="form-control input-radio '.$radio['classes'].'"';  
      } else {
        $output .= ' class="form-control input-radio"';
      }
      if ($default_value) {
        $output .= ' value="'.$radio['default_value'].'"';
      }
      if ($additional_attributes) {
        $output .= ' '.$radio['additional_attributes'];
      }
      if ($default_value && ($default_value == $radio['value'])) {
        $output .= ' checked';
      }
      $output .= '/> '.$radio['label'].'</label>';
      $r++;
    }
  }
  return $output;
}

function create_button($type = 'button', $href = '', $name, $label, $classes = '', $additional_attributes = '', $icon = '') {
  $output = '';
  if ($type == 'anchor') {
    $output .= '<a id="'.$name.'" href="'.$href.'"';  
  } else {
    $output .= '<button type="'.$type.'" id="'.$name.'"';  
  }
  if ($classes) {
    $output .= ' class="btn '.$classes.'"';  
  } else {
    $output .= ' class="btn';
  }
  if ($additional_attributes) {
    $output .= ' '.$additional_attributes;
  }
  $output .= '>';
  if ($icon) {
    $output .= '<i class="icon-'.$icon.' glyphicon glyphicon-'.$icon.'"></i> ';  
  }
  $output .= $label;
  if ($type == 'anchor') {
    $output .= '</a>';
  } else {
    $output .= '</button>';  
  }
  return $output;    
}

function create_input($input_defintion) {
  $output = '';
  if ($input_defintion['type'] == 'text') {
    $output = text_input($input_defintion['name'], $input_defintion['classes'], $input_defintion['state'], $input_defintion['default_value'], $input_defintion['additional_attributes']);
  }
  if ($input_defintion['type'] == 'textarea' || $input_defintion['type'] == 'longtext') {
    $output = textarea_input($input_defintion['name'], $input_defintion['classes'], $input_defintion['state'], $input_defintion['default_value'], $input_defintion['additional_attributes']);
  }
  if ($input_defintion['type'] == 'select' || $input_defintion['text'] == 'dropdown') {
    $output = select_input($input_defintion['name'], $input_defintion['classes'], $input_defintion['classes'], $input_defintion['state'], $input_defintion['default_value'], $input_defintion['additional_attributes']);
  }
  if ($input_defintion['type'] == 'checkbox') {
    $output = checkbox_input($input_defintion['options'], $input_defintion['default_value']);
  }
  if ($input_defintion['type'] == 'radio' || $input_defintion['type'] == 'switch') {
    $output = radio_input($input_defintion['options'], $input_defintion['name'], $input_defintion['default_value']);
  }
  return $output;
}

function create_bootstrap_input($type = 'text', $name, $options = array(), $label = '&nbsp;', $classes = '', $state = '', $default_value = '', $additional_attributes, $help = '', $required = false) {
  if ($required) {
    $classes .= ' input-required';
    $classes = trim($classes);
  }
  $output = '';
  $output .= '<div class="form-group"><label for="'.$name.'">'.$label.( $required?' <span class="required">*</span>':'' ).'</label>';
  if ($type == 'textarea' || $type == 'longtext') {
    $output .= textarea_input($name, $classes, $state, $default_value, $additional_attributes);
  } else if ($type == 'select' || $type == 'dropdown') {
    $output .= select_input($name, $options, $classes, $state, $default_value, $additional_attributes);
  } else if ($type == 'checkbox') {
    $output .= checkbox_input($options, $default_value);
  } else if ($type == 'radio' || $type == 'switch') {
    $output .= radio_input($options, $name, $default_value);
  } else {
    $output .= text_input($type, $name, $classes, $state, $default_value, $additional_attributes);
  }
  $output .= '<p class="help-block">'.$help.'</p></div>'."\n";
  return $output;
}

function create_bootstrap_input2($type = 'text', $name, $options = array(), $label = '&nbsp;', $classes = '', $state = '', $default_value = '', $additional_attributes, $help = '', $required = false) {
  if ($required) {
    $classes .= ' input-required';
    $classes = trim($classes);
  }
  $output = '';
  $output .= '<div class="form-group"><label for="'.$name.'" class="col-sm-2 control-label">'.$label.( $required?' <span class="required">*</span>':'' ).'</label>';
  $output .= '<div class="col-sm-10">';
  if ($type == 'textarea' || $type == 'longtext') {
    $output .= textarea_input($name, $classes, $state, $default_value, $additional_attributes);
  } else if ($type == 'select' || $type == 'dropdown') {
    $output .= select_input($name, $options, $classes, $state, $default_value, $additional_attributes);
  } else if ($type == 'checkbox') {
    $output .= checkbox_input($options, $default_value);
  } else if ($type == 'radio' || $type == 'switch') {
    $output .= radio_input($options, $name, $default_value);
  } else {
    $output .= text_input($type, $name, $classes, $state, $default_value, $additional_attributes);
  }
  $output .= '<p class="help-block">'.$help.'</p></div>'."\n";
  $output .= '</div>'."\n";
  return $output;
}