<form method="post" id="addResourceForm" action="<?php echo site_url('/pathfinder/add_resource') ?>">
  <select name="resource_ID" data-ajax-source="<?php echo site_url('/resource/ajax') ?>?type=<?php echo $type ?>" multiple="multiple" class="chosen-ajax">
    <option class=""></option>
  </select>
  <input type="hidden" name="pathfinder_ID" value="<?php echo $pathfinder_ID ?>">
  <div class="clearfix">&nbsp;</div>
  <input type="submit" name="save" class="btn btn-primary" value="Add Resource"/>
</form>
<?php exit(); ?>