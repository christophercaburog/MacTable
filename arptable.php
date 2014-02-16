#!/usr/bin/php
<?php
$a=file("/var/lib/arpwatch/arp.dat");
$c=array();
foreach ($a as $b) {
 $d=explode("\t",$b);
 if (!empty($d)) {
  if (!(empty($d[0]) and empty($d[1]))) {
   $e=array();
   $e["m"]=$d[0];
   $e["i"]=$d[1];
   $e["s"]=$d[2];
   if (!empty($d[3])) {
    $e["n"]=$d[3];
   }
   $c[]=$e;
  }
 }
}
$mon=new Mongo();
$db=$mon->test;
$col=$db->devices;
foreach ($c as $f) {
 $r=$col->findOne(array("m"=>$f["m"]));
  if ($r!=null) {
   $col->update(array("_id"=>$r["_id"]),array('$set'=>$f));
  } else {
   $col->insert($f);
 }
}
echo "Done\n";
