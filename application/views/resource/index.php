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
<div class="panel panel-default">
  <div class="panel-body">
    <?php echo create_button('anchor', site_url('resource/add'), 'add-resource', 'Add New Resource', 'btn-success', '', $icon = 'plus-sign') ?>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Author</th>
        <th>Subject</th>
        <th>Publish Year</th>
        <th>Publisher</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $n = 1;
      foreach ($records as $data) :
      ?>
      <tr>
        <td><?php echo $n ?></td><td><?php echo $data->title ?></td>
        <td><?php echo $data->authors ?></td><td><?php echo $data->subjects ?></td>
        <td><?php echo $data->publish_year ?></td><td><?php echo $data->publisher ?></td>
        <td><a class="btn btn-warning" href="<?php echo site_url('/resource/update/'.$data->id) ?>">Edit</a></td>
        <td><a class="btn btn-danger" href="<?php echo site_url('/resource/delete/'.$data->id) ?>">Delete</a></td>
      </tr>
      <?php
      $n++;
      endforeach;
      ?>
    </tbody>
  </table>
</div>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>