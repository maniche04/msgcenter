<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

echo "data: {\n";
echo 'data: "msg":"' . $msg . '"' . ",\n";
echo 'data: "from":"' . $from . '"' . "\n";
echo "data: }\n\n";
flush();
?>