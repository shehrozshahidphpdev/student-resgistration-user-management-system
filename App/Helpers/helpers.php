<?php

/* 
  This funciton 
*/
if (! function_exists('dump')) {
  function dump($data)
  {
    echo "<pre>";
    var_dump($data);
  }
}
/* 
  this functions var_dump the data and die at the same time
*/

if (! function_exists('dd')) {
  function dump($data)
  {
    echo "<pre>";
    var_dump($data);
  }
}
