#!/usr/bin/php
<?php
if ($argc==3) {
 $mon=new Mongo();
 $db=$mon->test;
 $col=$db->devices;
 print_r($argv);
 $col->update(array("m"=>$argv[1]),array('$set'=>array("n"=>$argv[2])));
}
