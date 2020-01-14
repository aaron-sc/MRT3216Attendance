<?php
function createDDL($result, $selectedId, $keyColumn, $displayColumn) {
    /*** loop over the results ***/
    foreach($result as $row)
    {
        /*** create the options ***/
        echo '<option value="'.$row[$keyColumn].'"';
        
        if($row[$keyColumn]==$selectedId)
        {
            echo ' selected';
        }
        echo '>'. $row[$displayColumn] . '</option>'."\n";
    }
}
?>