<?php

print_r($_SERVER['SERVER_NAME']);
print_r(trim(md5(hash('sha512',$_SERVER['SERVER_NAME']))));
//print_r($_SERVER['REMOTE_ADDR']);
//print_r(trim(md5(hash('sha512',$_SERVER['REMOTE_ADDR']))));

?>
