<?php
include_once "parameters.php";

class config{
    var $conn;
    function config(){
        $this->conn=mysql_connect(HOST,$this->x_encripts(US),$this->x_encripts(PS)) or die("No se pudo establecer una conexion con la base de datos! " . mysql_error());
        mysql_select_db(DB);
    }

    function x_encripts($data){
        $d=$data;
        $l=strlen($d);
        $p='';
        for($i=0;$i<$l;$i++){
            $t=substr($d, $i, 1);
            $x=ord($t) ^ X;
            $p.=chr($x);
        }
        return $p;
    }
    
    function listarPlanes($P, $cond=null, $n){
        $sql = "select codigo_{$P}, plan_{$P} from " . TAB . " where plan_{$P} not in ('NA') and ";
        $sql .= "municipio='{$cond[0]}' and estrato in ({$cond[1]}, 123456, 12, 3456) and of_naked={$n} ";
        $sql .= "group by codigo_{$P}, plan_{$P} order by codigo_{$P}";
        
        $res=mysql_query($sql);
        $vector=array();
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($vector, $row["codigo_{$P}"]."|".$row["plan_{$P}"]);
        }
        return $vector;
    }
    
    function listarPlanes2($P, $cond, $pss, $n){
        $sql="select codigo_{$P}, plan_{$P} from " . TAB . " a, " . TABO . " b where plan_{$P} not in ('NA') and municipio='{$cond[0]}' and b.tipo='{$P}' and b.cod_ps=codigo_{$P} ";
        if(strpos("56", $cond[1]) !== false){
            $sql.="and estrato in({$cond[1]}, 123456, 3456, 56)  and of_naked={$n} ";
        }
        else{
            $sql.="and estrato in({$cond[1]}, 123456, 12, 3456)  and of_naked={$n} ";
        }
        if($pss[0]!="NA"){
            $sql.="and codigo_ba='".$pss[0]."' ";
        }
        if($pss[1]!="NA"){
            $sql.="and codigo_tv='".$pss[1]."' ";
        }
        if($pss[2]!="NA"){
            $sql.="and codigo_lb='".$pss[2]."' ";
        }
        $sql.="group by codigo_{$P}, plan_{$P} order by b.orden";
//        echo $sql;
        
        $res=mysql_query($sql);
        $vector=array();
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($vector, $row["codigo_{$P}"]."|".$row["plan_{$P}"]);
        }
        return $vector;        
    }
    
    function listarMunicipios($dpto){
        $sql="select distinct municipio from ". TAB ." where municipio like '%{$dpto}%' order by municipio";
        $res=mysql_query($sql);
        
        
        $resultado=array();
        while($row=  mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($resultado, $row['municipio']);
        }
        
        return $resultado;
    }
    
    function listarDptos(){
        $sql = "select distinct dpto from (select substring(municipio,instr(municipio,'(')+1,instr(municipio,')')-(instr(municipio,'(')+1)) as dpto from " . TAB . ") as C order by dpto";
        $res = mysql_query($sql);
        $dptos=array();
        
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($dptos, $row);
        }
        
        return $dptos;
    }
    
    function listarMunis($dpto){
        $sql="select distinct substring( municipio, 1, instr( municipio, '(' ) -2 ) as muni from " . TAB . " where municipio like '%{$dpto}%' order by muni";
        $res = mysql_query($sql);
        $munis=array();
        
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($munis, $row);
        }
        
        return $munis;
    }
    
    function preciario($md, $es, $cods, $n){
        if($cods[0] == "NA" && $cods[1] != "NA" && $cods[2] == "NA"){ $es = 123456; }
        if($cods[0] == "NA" && $cods[1] == "NA" && $cods[2] != "NA"){
            if($es == 1 || $es == 2){ $es = 12; }
            if($es == 3 || $es == 4 || $es == 5 || $es == 6){ $es = 3456; }
        }
        else{
            if($es == 5 || $es == 6){ $es = 56; }
        }
        $sql = "select mx, vlr_lb_empaq, vlr_ba_empaq, vlr_tv_empaq, vlr_lb_full, ";
        $sql .= "vlr_ba_full, vlr_tv_full, instala_deco_1, dcto_ba, vlr_total_dcto, instala_ba, mensaje_dcto from " . TAB . " where codigo_lb='" . $cods[2] . "' ";
        $sql .= "and codigo_ba='" . $cods[0] . "' and codigo_tv='" . $cods[1] . "' and municipio='{$md}' ";
        $sql .= "and estrato={$es}" . " and of_naked={$n}";

        //echo $sql;

        $res = mysql_query($sql);
        $resultado = array();
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($resultado, $row);
        }
        return $resultado;
    }
    
    function valoresSVATv($md, $es, $cods, $n){
        if($cods[0] == "NA" && $cods[1] != "NA" && $cods[2] == "NA"){ $es = 123456; }
        if($cods[0] == "NA" && $cods[1] == "NA" && $cods[2] != "NA"){
            if($es == 1 || $es == 2){ $es = 12; }
            if($es == 3 || $es == 4 || $es == 5 || $es == 6){ $es = 3456; }
        }
        else{
            if($es == 5 || $es == 6){ $es = 56; }
        }
        //VLR_DECO_ADIC, VLR_DECO_HD
        $sql = "select vlr_hbo_max, vlr_hbo_max_dcto, vlr_hbo_mini, vlr_hbo_mini_dcto, vlr_fox_plus, vlr_fox_plus_dcto, vlr_ufc, vlr_ufc_dcto, vlr_fox_plus_mini, vlr_plan_cine, vlr_adultos_plus, vlr_adultos_plus_dcto, vlr_adultos_total, vlr_adultos_total_dcto, vlr_cine_extremo, vlr_canales_audio, cod_atis, vlr_hd_plus, vlr_hd_plus_dcto, vlr_hd_total, vlr_hd_total_dcto, vlr_pvr, vlr_deco_sd, vlr_deco_hd, aplica_hd, instala_deco_2, q_decos from " . TAB . " where municipio='{$md}' and estrato='{$es}' and codigo_ba='" . $cods[0] . "' and codigo_tv='" . $cods[1] . "' and codigo_lb='" . $cods[2] . "' and of_naked={$n}";

        //echo $sql;
        $res = mysql_query($sql);
        $resultado = array();
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($resultado, $row);
        }
        return $resultado;
    }

    function valoresSVABa($md, $es, $cods, $n){
        if($cods[0] == "NA" && $cods[1] != "NA" && $cods[2] == "NA"){ $es = 123456; }
        if($cods[0] == "NA" && $cods[1] == "NA" && $cods[2] != "NA"){
            if($es == 1 || $es == 2){ $es = 12; }
            if($es == 3 || $es == 4 || $es == 5 || $es == 6){ $es = 3456; }
        }
        else{
            if($es == 5 || $es == 6){ $es = 56; }
        }
        //VLR_DECO_ADIC, VLR_DECO_HD
        $sql = "select vlr_cds_1, vlr_cds_2, vlr_cds_3, vlr_conexion_seg, vlr_antivirus, vlr_tutor, vlr_aula, vlr_napster, vlr_internet_f_m, mx from " . TAB . " where municipio='{$md}' and estrato='{$es}' and codigo_ba='" . $cods[0] . "' and codigo_tv='" . $cods[1] . "' and codigo_lb='" . $cods[2] . "' and of_naked={$n}";

        $res = mysql_query($sql);
        $resultado = array();
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($resultado, $row);
        }
        return $resultado;
    }
     
    function valoresSVALb($md, $es, $cods, $n){
        if($cods[0] == "NA" && $cods[1] != "NA" && $cods[2] == "NA"){ $es = 123456; }        
        if($cods[0] == "NA" && $cods[1] == "NA" && $cods[2] != "NA"){
            if($es == 1 || $es == 2){ $es = 12; }
            if($es == 3 || $es == 4 || $es == 5 || $es == 6){ $es = 3456; }
        }
        else{
            if($es == 5 || $es == 6){ $es = 56; }
        }

        $sql = "select vlr_paq_identif_llam_buz, vlr_paq_identif_llam_transf, vlr_conex_sin_marcar, vlr_marcacion_abrev, vlr_identif_llamadas, vlr_transf_ocupado, vlr_llam_tripartita, vlr_despertador_autom, vlr_fmilia_amigos, vlr_pref_fijo_movil, vlr_llamada_espera, vlr_buzon_res, vlr_desvio_no_contesta, vlr_transf_inmediata, vlr_asistencia_vial, vlr_asistencia_hogar, vlr_asistencia_pref from " . TAB . " where municipio='$md' and estrato='$es' and codigo_ba='" . $cods[0] . "' and codigo_tv='" . $cods[1] . "' and codigo_lb='" . $cods[2] . "' and of_naked=$n;";

        //echo $sql; 
        $res = mysql_query($sql);
        $resultado = array();
        while($row = mysql_fetch_assoc($res)){
            array_push($resultado, $row);
        }

        return $resultado;
    }

    function leerObs($md, $es, $cods, $n){
        if($cods[0] == "NA" && $cods[1] != "NA" && $cods[2] == "NA"){ $es = 123456; }
        if($cods[0] == "NA" && $cods[1] == "NA" && $cods[2] != "NA"){
            if($es == 1 || $es == 2){ $es = 12; }
            if($es == 3 || $es == 4 || $es == 5 || $es == 6){ $es = 3456; }
        }
        if($es == 5 || $es == 6){ $es = "56"; }
        $sql = "select observaciones, mx, aplica_hd from " . TAB . " where municipio='{$md}' and estrato={$es} ";
        $sql .= "and codigo_ba='" . $cods[0] . "' and codigo_tv='" . $cods[1] . "' and codigo_lb='" . $cods[2] . "' and of_naked={$n}";
        
        $res = mysql_query($sql);
        $resultado = array();
        while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
            array_push($resultado, $row);
        }
        return $resultado;
    }
    
    function recSurvey($us, $asurvey){
        $respuesta = "";
        $sql = "select count(1) as TOTAL from cot_residencial_survey where usuario='{$us}' and day(fecha)=day(curdate()) ";
        $sql .= "and month(fecha)=month(curdate()) and year(fecha)=year(curdate())";
        $res=mysql_query($sql);
        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        
        $tot=$row["TOTAL"];
        
        if($tot == 0){
            $respuesta = "NEW";
            $sql = "insert into cot_residencial_survey values (null, '{$us}', curdate(), {$asurvey[0]}, {$asurvey[1]}, {$asurvey[2]}, {$asurvey[3]}, 1)";
            $res = mysql_query($sql);
        }else{
            $respuesta = "HERE";
            $sql = "select conteo from cot_residencial_survey where usuario='{$us}' and day(fecha)=day(curdate()) ";
            $sql .= "and month(fecha)=month(curdate()) and year(fecha)=year(curdate())";
            $res = mysql_query($sql);
            $row = mysql_fetch_array($res, MYSQL_ASSOC);
            
            $conteo = $row["conteo"] + 1;
            
            $sql = "update cot_residencial_survey set conteo=" . $conteo. " where usuario='{$us}' and day(fecha)=day(curdate()) ";
            $sql .= "and month(fecha)=month(curdate()) and year(fecha)=year(curdate())";
            $res = mysql_query($sql);
        }
        return $respuesta;
    }
    
    function promediosQ(){
        $sql = "select avg(comprension) as Q1, avg(funcionalidad) as Q2, avg(tiempos) as Q3, avg(diseno) as Q4 from cot_residencial_survey";
        $res = mysql_query($sql);
        
        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        $Qs = array();
        
        array_push($Qs, $row["Q1"]);
        array_push($Qs, $row["Q2"]);
        array_push($Qs, $row["Q3"]);
        array_push($Qs, $row["Q4"]);
        
        return $Qs;
    }
    
    function reviewQuote($md, $es, $cods, $n){
        if($cods[0] == "NA" && $cods[1] != "NA" && $cods[2] == "NA"){ $es = 123456; }
        if($cods[0] == "NA" && $cods[1] == "NA" && $cods[2] != "NA"){
            if($es == 1 || $es == 2){ $es = 12; }
            if($es == 3 || $es == 4 || $es == 5 || $es == 6){ $es = 3456; }
        }
        if($es == 5 || $es == 6){ $es = "56"; }
        $sql = "select vlr_lb_empaq, vlr_ba_empaq, vlr_tv_empaq, mx, instala_deco_1, cod_atis from " . TAB ." ";
        $sql .= "where municipio='{$md}' and estrato={$es} and codigo_lb='{$cods[2]}' and codigo_ba='{$cods[0]}' ";
        $sql .= "and codigo_tv='{$cods[1]}' and of_naked={$n}";        
        
        $res = mysql_query($sql);
        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        
        $vlb = $row["vlr_lb_empaq"];
        $vba = $row["vlr_ba_empaq"];
        $vtv = $row["vlr_tv_empaq"];
        
        
        $mxs = "TRIO, DUO TV, TV SOLA";
        $vlpf = $vlb + $vba + $vtv;
        $vlsf = $vlpf;
        $quote = array();
        
        
        if(strpos($mxs, $row["mx"]) >= 0){
            $vlpf += $row["instala_deco_1"];
        }
        array_push($quote, $vlpf); //Valor primera factura
        array_push($quote, $vlsf); //Valor segunda factura
        array_push($quote, $row["mx"]); //Portafolio
        array_push($quote, $row["cod_atis"]); //Portafolio
        array_push($quote, $sql); //SQL
        
        return $quote;
    }
    
    function getPoliticas($codatis){
        $sql = "select cobertura, politica from explora_cotizadores_politicas_decos where cod_atis={$codatis}";
        //echo $sql;
        $res = mysql_query($sql);
        $politica = mysql_fetch_assoc($res);
        
        return $politica;
    }
    
    function getNakedProperty($md){
        $sql = "select distinct of_naked from " . TAB . " where municipio='{$md}'";
        $res = mysql_query($sql);
        $vector = array();
        while($row = mysql_fetch_assoc($res)){
            $vector[] = $row;
        }
        $esNak = 0;
        if(count($vector) > 1){ $esNak = 1; }
        return $esNak;
    }
    
    function getMD($ca){
        $sql = "select municipio from " . TAB . " where cod_atis={$ca} limit 1;";
        $res = mysql_query($sql);
        $row = mysql_fetch_assoc($res);

        return $row["municipio"];
    }

    function getValoresDecos($md){
        if($md == "San Andres (SAN ANDRES Y PROV.)"){
            $sql = "select tipo, ps, valor_siniva, cantidad from " . TABD . " where tipo in ('sdesp') order by orden_tipo, cantidad";
        }else if($md == "Leticia (AMAZONAS)"){
            $sql = "select tipo, ps, valor_siniva, cantidad from " . TABD . " where tipo not in ('sdesp') order by orden_tipo, cantidad";
        }else{
            $sql = "select tipo, ps, valor_iva, cantidad from " . TABD . " where tipo not in ('sdesp') order by orden_tipo, cantidad";
        }
        $res = mysql_query($sql);
        $listado = array();
        while($row = mysql_fetch_row($res)){
            $listado[] = array("tipo" => $row[0], "ps" => $row[1], "valor" => $row[2], "cantidad" => $row[3]);
        }

        return $listado;
    }

    function PlanesBa($es, $ca){
        $nes = $es;
        //if($es == 1 || $es == 2){ $nes = "12"; }
        if($es == 5 || $es == 6){ $nes = "56"; }
        //if($es == 3 || $es == 4){ $nes = "3456"; }

        $sql = "select codigo_ba, plan_ba from " . TAB . " where cod_atis={$ca} and plan_ba not like '%duo%'and estrato in ({$es},{$nes}) group by codigo_ba, plan_ba order by codigo_ba";
        $res = mysql_query($sql);
        $lista = array();
        while($row = mysql_fetch_assoc($res)){
            $lista[] = $row;
        }
        return $lista;
    }
    function PlanesTv($es, $ca){
        $nes = $es;
        //if($es == 1 || $es == 2){ $nes = "12"; }
        if($es == 5 || $es == 6){ $nes = "56"; }
        //if($es == 3 || $es == 4){ $nes = "3456"; }

        $sql = "select codigo_tv, plan_tv from " . TAB . " where cod_atis={$ca} and estrato in ({$es},{$nes}) group by codigo_tv, plan_tv order by codigo_tv";
        $res = mysql_query($sql);
        $lista = array();
        while($row = mysql_fetch_assoc($res)){
            $lista[] = $row;
        }
        return $lista;
    }
    function PlanesLb($es, $ca){
        $nes = $es;
        //if($es == 1 || $es == 2){ $nes = "12"; }
        if($es == 5 || $es == 6){ $nes = "56"; }
        //if($es == 3 || $es == 4){ $nes = "3456"; }

        $sql = "select codigo_lb, plan_lb from " . TAB . " where cod_atis={$ca} and estrato in ({$es},{$nes}) group by codigo_lb, plan_lb order by codigo_lb";
        $res = mysql_query($sql);
        $lista = array();
        while($row = mysql_fetch_assoc($res)){
            $lista[] = $row;
        }
        return $lista;
    }

    function GetResults($token){
        $es = $token["est"];
        $ca = $token["cod_atis"];
        $psba = $token["cod_ba"];
        $pstv = $token["cod_tv"];
        $pslb = "2845";
        if(strpos("2996,2997,2998,2999,3002,3003,3004", $psba) === false){
            $pslb = "2722";
        }
        $nes = "";
        if($es == "1" || $es == "2"){ $nes = "12"; }
        if($es == "5" || $es == "6"){ $nes = "56"; }
        if($es == "3" || $es == "4"){ $nes = "3456"; }

        $sql = "select mx, vlr_total, vlr_total_dcto from " . TAB . " where cod_atis=" . $ca . " and estrato in (" . $es . "," . $nes . ") and codigo_ba='" . $psba . "' and codigo_tv='" . $pstv . "' and codigo_lb='" . $pslb . "';";
        $lista = array();
        
        $res = mysql_query($sql);
        while($row = mysql_fetch_assoc($res)){
            $lista[] = $row;
        }
        
        return $lista;
    }

    function getActualTable(){
        return TAB;
    }
    
}
