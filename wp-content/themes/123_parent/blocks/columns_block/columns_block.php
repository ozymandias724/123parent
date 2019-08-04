<?php
/**
* Columns Block
* 
* This block allows 1-3 repeater rows of flexible content layouts to be added.
* Each repeater row will represent a column on the page.
* Each flexible content layout will be a row within that column.
*/
// return string
$return['columns_block'] = '';
// return string
$return['columns'] = '';

/**
 *  if we have columns
 */ 
// get column count
$cols = count($cB['columns']);

// open section and container
$return['columns_block'] .= '<section class="site__block block__columns"><div class="container ' . $cB['width'] . '">';


// heading + sub heading please
$return['columns_block'] .= '<h2 class="block-heading">'.$cB['heading'].'</h2>';
$return['columns_block'] .= '<p class="block-subheading">'.$cB['sub_heading'].'</p>';

// open columns <ul>
$return['columns'] .= '<div class="flexgrid cols-'.$cols.'"><ul>';

// loop thru each column
foreach ($cB['columns'] as $i => $column) {
    
    // open this column as a <li>
    $return['columns'] .= '<li>';

    // within this column, loop thru each row
    foreach ($column as $rows) {

        // within this row, loop thru the flexible content layouts
        foreach($rows as $row){

            // include content blocks...
            $cB = $row;
            
            ob_start();
            $path = get_template_directory() . '/blocks/'.$cB['acf_fc_layout'].'/'.''.$cB['acf_fc_layout'].'.php';
            // include the block
            if( file_exists($path) ){
                include($path);
            }
            
            $return['columns'] .= ob_get_clean();
        }
    }
    // close row container
    $return['columns'] .= '</li>';
}
// close column container
$return['columns'] .= '</ul></div>';

// write columns into section
$return['columns_block'] .= $return['columns'];

// close and echo the section
echo $return['columns_block'] . '</div></section>';

?>