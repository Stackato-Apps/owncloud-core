<?php
$appinfo = getenv("VCAP_APPLICATION");

$url_parts = parse_url($_SERVER['DATABASE_URL']);
$db_name = substr( $url_parts{'path'}, 1 );

$AUTOCONFIG = array(
"installed" => false,
"adminlogin" => "stackato",
"adminpass" => "changeme",
"directory" => "/home/stackato/app/data",
"dbtype" => "mysql",
"dbname" => $db_name,
"dbuser" => $url_parts{'user'},
"dbpass" => $url_parts{'pass'},
"dbhost" => $url_parts{'host'},
"dbtableprefix" => "oc_",
"3rdpartyroot" => OC::$SERVERROOT."/3rdparty",
"3rdpartyurl" => "/3rdparty"
);
?>
