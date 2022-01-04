<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.css"/>

<?php

$nodes = \App\Models\Unit\UnitTerritory::where('status', 'active')->get()->toArray();
//
//$traverse = function ($categories, $prefix = '-') use (&$traverse) {
//    foreach ($categories as $category) {
//        echo PHP_EOL.$prefix.' '.$category->name.'<br>';
//
//        $traverse($category->children, $prefix.'-');
//    }
//};
//
//$traverse($nodes);

//    function buildMenu($nodes, $parentid = 0)
//    {
//  $result = null;
//  foreach ($nodes as $item)
//    if ($item['parent_id'] == $parentid) {
//      $result .= "<li class='dd-item nested-list-item' data-order='{$item['name']}' data-id='{$item['id']}'>
//      <div class='dd-handle nested-list-handle'>
//        <span class='glyphicon glyphicon-move'></span>
//      </div>
//      <div class='nested-list-content'>{$item['name']}
//        <div class='pull-right'>
//          <a href='".url("admin/menu/edit/{$item['id']}")."'>Edit</a> |
//          <a href='#' class='delete_toggle' rel='{$item['id']}'>Delete</a>
//        </div>
//      </div>".$this->buildMenu($nodes, $item['id']) . "</li>";
//    }
//  return $result ?  "\n<ol class=\"dd-list\">\n$result</ol>\n" : null;
//}
//print buildMenu($nodes);




function get_menu($items) {

    $html = "<ol class=\"dd-list\" id=\"menu-id\">";

foreach($items as $node) {
    $html.= '<li class="dd-item dd3-item" data-id="'.$node['id'].'" >
                    <div class="dd-handle"><span id="label_show'.$node['id'].'">'.$node['name'].'</span>
                        <span class="span-right" style="float: right">
                            <a class="edit-button" id="'.$node['id'].'" >Edit |</a>
                            <a class="del-button" id="'.$node['id'].'">Delete</a></span>
                    </div>';
    if(array_key_exists('child',$node)) {
        $html .= get_menu($node['child'],'child');
    }
    $html .= "</li>";
}
$html .= "</ol>";
    return $html;
}

print get_menu($nodes);



//$root = \App\Models\Unit\UnitTerritory::find(1);
//
//// We need to find our children. We don't do this lazily because it can be
//// advantageous to control when it happens. You may wish to provide a
//// $depth limit to speed up queries even more.
//$depth = 2; // This will limit to countries & states only for example
//$root->findChild($depth);
//
//// We can now loop through our children
//foreach ($root->getChild() as $country)
//{
//    echo "<h3>{$country->name}</h3>";
//
//    if (count($country->getChild()))
//    {
//        echo "<p>{$country->name} has the following states registered with our system:</p>";
//
//        echo "<ul>";
//
//        foreach ($country->getChildren() as $state)
//        {
//            echo "<li>{$state->name}</li>";
//        }
//
//        echo "</ul>";
//    }
//}

