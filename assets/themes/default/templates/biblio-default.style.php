<?php
function biblio_style_header($pathfinder, $logged_in, $group) {
  ?>
  <ul class="list-group">
  <?php
}

function biblio_style_footer($pathfinder, $logged_in, $group) {
  ?>
  </ul>
  <?php
}

function biblio_style($pathfinder, $doc, $logged_in, $group) {
  ?>
  <li class="list-group-item doc">
    <span class="doc-field doc-title"><a href="<?php print site_url('/resource/detail/'.$doc->id) ?>"><?php print $doc->title ?></a></span>
    <div>
        <span class="doc-field doc-author"><strong>Author(s):</strong> <?php print $doc->authors ?></span> &mdash;
        <span class="doc-field doc-year"><strong>Publish year:</strong> <?php print $doc->publish_year ?></span> &mdash;
        <?php
        if ($doc->location) {
            echo '<span class="doc-field doc-url"><strong>Location:</strong> '.$doc->location.'</span>';  
        }
        if ($doc->url) {
            echo '<span class="doc-field doc-url"><strong>URL:</strong> <a href="'.$doc->url.'" target="_blank">'.$doc->url.'</a></span>';  
        }
        ?>
    </div>
    <div class="doc-field doc-buttons">
        <a class="btn btn-sm btn-info resource-detail-btn" title="View Detail"
        href="<?php print site_url('/resource/detail/'.$doc->id) ?>"><i class="glyphicon glyphicon-book"></i> Detail</a>
        <?php
        if ($logged_in && $group == 'Librarian') {
            echo '<a class="btn btn-sm btn-warning" title="Edit this resource from this pathfinder" 
                href="'.site_url('/resource/update/'.$doc->id).'"><i class="glyphicon glyphicon-pencil"></i> Edit Resource Data</a> ';
            echo '<a class="btn btn-sm btn-danger" title="Remove this resource from this pathfinder" data-confirm="Are you sure want to remove this resource from this pathfinder?"
                href="'.site_url('/pathfinder/remove_resource/'.$pathfinder->id.'/'.$doc->id).'"><i class="glyphicon glyphicon-trash"></i></a>';
        }
        ?>
    </div>
  </li>
<?php }
