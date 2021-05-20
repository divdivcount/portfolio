<?php
/*
FileName: strequ.php
Modified Date: 20210317
Description: 문자열 일치 검사 함수
reference: https://jhrun.tistory.com/179 [JHRunning]
*/
// Load Modules

// Parameter

// Functions
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

// Process
?>
