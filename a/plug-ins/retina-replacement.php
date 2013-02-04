<?
function is_in_string($haystack, $needle) { 
    if (strpos($haystack, $needle) !== false) {
        return 1;
    } else {
        return 0;
    }
}

function get_dir_contents($web_directory) {
    $directory = $_SERVER['DOCUMENT_ROOT'].$web_directory;
    if(file_exists($directory)) {
        $myDirectory = opendir($directory);

        while($entryName = readdir($myDirectory)) {
            if (is_in_string($entryName, "-2x")){
                $dirArray[] = $entryName;   
            }
        }

        return $dirArray;
    }
}

header('Content-type: application/json');
echo json_encode(get_dir_contents("/a/img"));
?>