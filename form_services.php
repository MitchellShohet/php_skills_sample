<?php


    function read_catalog($file) {
        $handle = fopen($file, 'r');
        $contents = fread($handle, filesize(($file)));
        $catalog = [json_decode($contents, true)];
        fclose($handle);
        return $catalog;
    }

    function add_to_catalog($file, $entry) {
        $prev_catalog = read_catalog($file);
        $new_contents = array_merge($prev_catalog, [$entry]);
        $new_catalog = json_encode($new_contents);
        $handle = fopen($file, 'w');
        fwrite($handle, $new_catalog);
        fclose($handle);
    }
?>