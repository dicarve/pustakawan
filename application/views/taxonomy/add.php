<?php
/**
 *
 * Copyright (C) 2014  Arie Nugraha (dicarve@gmail.com)
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

ob_start();
?>
<form role="form" method="post" name="pathfinder-form" id="pathfinder-form" action="<?php echo site_url('/taxonomy/save/'.$type) ?>">
<?php echo create_bootstrap_input('text', 'name', array(), 'Term Name', '', '', isset($record->name)?$record->name:'', '', 'Name of term', true) ?>
<?php echo create_bootstrap_input('text', 'description', array(), 'Description', '', '', isset($record->description)?$record->description:'', '', 'Description/qualifier of term') ?>
<?php
  $weight_options = array();
  for ($i = -50; $i < 51; $i++ ) { $weight_options[$i] = $i; }
  
  echo create_bootstrap_input('select', 'weight', $weight_options, 'Weight', '', '', isset($record->weight)?$record->weight:'', 'style="width: 75px;"', 'Weight for term');
?>
<input type="hidden" name="type" value="<?php echo $type ?>" />
<?php
  if (isset($update_ID)) {
    echo text_input('hidden', 'update_ID', '', '', $update_ID);
    echo text_input('button', 'cancel', 'btn btn-warning', '', 'Cancel', 'onclick="javascript: history.back()"');
    echo '&nbsp;';
  }
  echo text_input('submit', 'save', 'btn btn-primary', '', 'Save Term');
?>
</form>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>