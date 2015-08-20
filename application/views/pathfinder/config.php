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
<form role="form" method="post" name="pathfinder-form" id="pathfinder-form" action="<?php echo site_url('/pathfinder/config/save') ?>">
<?php echo create_bootstrap_input('text', 'site_name', array(), 'Site name', '', '', '', '', 'Name of this pathfinder site') ?>
<?php echo create_bootstrap_input('textarea', 'contact', array(), 'Contact Information', '', '', '', '', 'Library/Librarian contact information') ?>
<?php echo create_bootstrap_input('textarea', 'homepage', array(), 'Homepage Information', '', '', '', '', 'Information that appears on the homepage') ?>
<?php echo text_input('submit', 'save', 'btn btn-primary', '', 'Save Configuration') ?>
</form>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>