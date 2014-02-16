<?php
$showhidden=filter_input(INPUT_GET,"showhidden",FILTER_VALIDATE_BOOLEAN);
$asjson=filter_input(INPUT_GET,"asjson",FILTER_VALIDATE_BOOLEAN);
$m=new Mongo();
$a=$m->test->devices->find()->sort(array("i"=>1));
if ($asjson) {
 $c=array();
 foreach ($a as $b) {
  unset($b["_id"]);
  if ($showhidden or isset($b["n"])) {
   $c[]=$b;
  }
 }
echo json_encode(array("devices"=>$c));
} else {
?><table border="1">
<tr><th>Name</th><th>Last seen ip</th><th>Mac</th><th>Last seen</th></tr>
<?php
 foreach ($a as $b) {
  if (isset($b["i"])) {
   if (isset($b["n"])) {
     echo "<tr><td>".$b["n"]."</td><td>".$b["i"]."</td><td>".$b["m"]."</td><td>".date(DATE_RSS,$b["s"])."</td></tr>\n";
   } else {
     if ($showhidden) {
      echo "<tr><td></td><td>".$b["i"]."</td><td>".$b["m"]."</td><td>".date(DATE_RSS,$b["s"])."</td></tr>\n";
     }
    }
   }
  }
?>
</table>
<?php if ($showhidden) { ?>
<a href="?showhidden=false">Hide hidden</a>
<?php } else {?>
<a href="?showhidden=true">Show hidden</a>
<?php }
}
