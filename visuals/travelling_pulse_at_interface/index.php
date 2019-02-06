<?php
$text_id = str_replace(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/","",__FILE__);
$text_id = str_replace("/index.php","",$text_id);
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_visual.php';
?>