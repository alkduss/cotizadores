<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once "data/config.php";
$C = new config();

$est = $_REQUEST["es"];
$catis = $_REQUEST["ca"];
$psba = $_REQUEST["psba"];

$json = '[';

if($psba == ""){
	$listaba = $C->PlanesBa($es, $catis);
	if(count($listaba) == 0){
		$json .= '{"error":"No existen planes en la selección"},';
	}
	else{
		foreach ($listaba as $k => $v) {
			$json .= '{"id":"' . $v["codigo_ba"] . '",';
			$json .= '"value":"' . $v["plan_ba"] . '",';
			$json .= '"type":"ba"},';
		}
	}
}
else{
	$listatv = $C->PlanesTv($es, $catis, $psba);
	if(count($listatv) == 0){
		$json .= '{"error":"No existen planes en la selección"},';
	}
	else{
		foreach ($listatv as $k => $v) {
			$plantv = explode(" ", $v["plan_tv"]);
			$json .= '{"id":"' . $v["codigo_tv"] . '",';
			$json .= '"value":"' . $plantv[0] . '",';
			$json .= '"type":"tv"},';
		}	
	}
}

$json = substr($json, 0, -1) . ']';
echo $json;