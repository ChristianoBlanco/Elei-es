<?php
function unique_salt()
{
return substr(sha1(mt_rand()), 0, 222);
}
?>