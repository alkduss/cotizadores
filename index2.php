<?php
include_once 'data/config.php';
$cx=new config();

$CA = $_REQUEST["ca"];
$dptos = $cx->listarDptos();
$E = $_REQUEST["es"];
$op = $_REQUEST["op"];
$user = $_REQUEST["user"];
$token = $_REQUEST["token"];
$t = $_REQUEST["T"];

$dps = array();
foreach ($dptos as $value){
	$dps[] = $value["dpto"];
}
$vigencia = "Oferta v&aacute;lida desde <b>1-Octubre-2017</b>";
$myTable = $cx->getActualTable();
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=8,9" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<meta charset="UTF-8">
	<title>Cotizador Mult. Residencial</title>
	<link href="scripts/js-ui/jquery-ui.css" rel="stylesheet" />
	<link href="media/tooltipster.css" rel="stylesheet" />
	<link href="media/themes/tooltipster-noir.css" rel="stylesheet" />
	<link href="media/estiler.css" rel="stylesheet" />
</head>
<body>
	<div class="toCenter wt">
		<img src="images/BannerTitulo.png" alt="" />
	</div>
	<div class="toCenter wt tac bgbox barra" tag="boxfilters">
		&nbsp;&nbsp;&nbsp;Filtros iniciales (Departamento, ciudad/municipio y estrato)
	</div>
	<div class="toCenter wt pos-ition bgbox padbox" id="boxfilters">
		<div style="padding: 5px;background-color: white;" class="pos-ition">
			<div class="bot fl" onclick="reCargar();">Reiniciar el cotizador</div>
			<div class="bot fl" ><?php echo $vigencia ?></div>
			<?php if($op=="BO"){ ?>
				<div class="botri fl" id='bBO'>Grabar para B.O.</div>
			<?php } ?>
			<?php if($t == 1): ?>
				<div class="bot fl"><?php echo $myTable ?></div>
			<?php endif ?>
			<div class="cl"></div>
			<table width='500' cellpadding='0' cellspacing='0'>
				<tr>
					<td class='f10' align='left' colspan='3'>
						B&uacute;squeda r&aacute;pida por municipio:
					</td>
				</tr>
				<tr>
					<td colspan='3' align='left'>
						<input type='text' id='txtSearchy' style="width: 500px;" />
					</td>
				</tr>
				<tr>
					<td class='f10' align='left'>
						Departamento: <span id="dp"></span>
					</td>
					<td class='f10' align='left'>
						Ciudad o Municipio: <span id="mp"></span>
					</td>
					<td class='f10' align='left'>
						Estrato:
					</td>
				</tr>
				<tr>
					<td align='left'>
						<select id='cboDpty'>
							<option value='-1' selected='selected'>...</option>
							<?php
							for($i=0; $i<count($dps); $i++){
								echo "<option value='".$dps[$i]."'>".$dps[$i]."</option>";
							}
							?>
						</select>
					</td>
					<td align='left'>
						<div id='dcboMuny'>
							<select id='cboMuny'>
								<option value='-1' selected='selected'>...</option>
							</select>
						</div>
					</td>
					<td align='left'>
						<select id='cboEstry' onchange='generarPlanes(this.value, 0);'>
							<option value='-1' selected='selected'>...</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="toCenter wt tac bgbox barra" tag="boxTotales">
		&nbsp;&nbsp;&nbsp;Totales
	</div>
	<div class="toCenter wt pos-ition bgbox padbox" id="boxTotales">
		<div style="padding: 5px;background-color: white;" class="pos-ition">
			Totales y pagos por meses
		</div>
	</div>
	<div class="publicidad" style="display:none;"></div>
	<div class="toCenter wt tac bgbox barra" tag="boxplanes">
		&nbsp;&nbsp;&nbsp;Selecci&oacute;n de productos
	</div>
	<div class="toCenter wt pos-ition bgbox padbox" id="boxplanes">
		<div style="padding: 5px;background-color: white;" class="pos-ition">
			<div class="tagger">
				<div style="display:none;" class="tab tooltyp" id="a1" onclick="offerCustomer(0);" title="<b>Oferta convencional</b><br>Aplica para clientes con<br>PC l&iacute;nea.">
					Oferta Convencional DUO/TRIO/TV
				</div>
				<div style="display:none;" class="tab-active tooltyp" id="a2" onclick="offerCustomer(1);" title="<b>Oferna Nueva IP</b><br>Aplica para clientes nuevos o<br>existentes con PC Internet.">
					Oferta Nueva IP - DUO/TRIO/TV
				</div>
				<div class="cl"></div>
				<div class="folder" tag="a1">
					<div class="cont-folder">
						<div class="bot fl" onclick="reinicioSeleccion();">Reiniciar selecciones</div><div class="cl"></div>
						<!-- Sección para producto Movistar Go //////////////////// -->
						<div class="zone">
							<div id="dMovistarGo">
								<img src="images/IconMovistarGo.png" alt="" /> <img src="images/LogoMovistarGo.png" alt="" />
							</div>
							<div class="fr" id='tmg' tag="4"></div>
							<div id="dmg">
								<div id='smg' style="display:none;">
									<div id='mg0' class='plan'>
										<div class="icon-info tooltyp" style="display: none;" title="Selecci&oacute;n:<b> TRIO + BA</b> mayor o igual a <b>10MB</b><br>Movistar Play incluido en el paquete por $ 0"></div>
										[<span id="psmv">2458</span>] - Plan Movistar Play
									</div>
									<div class="fl cur">
										<img id='amg0' alt='' src='images/StayPlan.jpg' />
									</div>
									<div class="cl"></div>
								</div>
							</div>
							<div id="msgMG" style="display:none;" class="infoMG">
								<span>[2736] - Dcto. Movistar	Play 50% x 6 meses<br>(activaci&oacute;n autom&aacute;tica)</span>
							</div>
							<div id="msgFree" style="display:none;" class="infoMG">
								<b>Importante</b><br>
								<span>Registrar PS <b>2863</b> Movistar Play incluido</span>
							</div>
						</div>
						<!-- Fin sección para producto Movistar Go //////////////////// -->

						<div class="zone fl">
							<div class="fl">
								<img id="iba" src="images/LogoInternet.png" alt="" />
							</div>
							<div class="fr">
								<img class="mtool" id="tba" src="images/Ind0.png" alt="" tag="-1" />
							</div>
							<div class="cb"></div>
							<div id="dba">
								<i>Selecciona depertamento, municipio y estrato...</i>
							</div>
						</div>

						<div class="zone fl">
							<div class="fl">
								<img id="itv" src="images/LogoTelevision.png" alt="" />
							</div>
							<div class="fr">
								<img class="mtool" id="ttv" src="images/Ind0.png" alt="" tag="-1" />
							</div>
							<div class="cb"></div>
							<div id="dtv">
								<i>Selecciona depertamento, municipio y estrato...</i>
							</div>
						</div>

						<div class="zone fl">
							<div class="fl">
								<img id="ilb" src="images/LogoLineaBasica.png" alt="" />
							</div>
							<div class="fr">
								<img class="mtool" id="tlb" src="images/Ind0.png" alt="" tag="-1" />
							</div>
							<div class="cb"></div>
							<div id="dlb">
								<i>Selecciona depertamento, municipio y estrato...</i>
							</div>
						</div>
						<div class="cl"></div>
						<div style="margin:10px 0 5px 0;"><b style="color:#C3007A;">Notas y Observaciones</b></div>
						<div id="notas"></div>
						<div id="notanaked" style="display:none;">
							<b style="color:red;">Importante!</b><br>
							Para Duo TV Seleccionar los PS de la oferta convencional (No aplica PS de oferta IP)
						</div>
					</div>
				</div>
				<div class="folder" style="display:none;" tag="a2"></div>
			</div>
		</div>
	</div>
	<div class="toCenter wt tac bgbox-c barra" tag="dsvaba">
		&nbsp;&nbsp;&nbsp;Selecci&oacute;n de SVA's para Internet
	</div>
	<div class="toCenter wt pos-ition bgbox padbox" id="dsvaba">
		<div style="padding: 5px;background-color: white;" class="pos-ition" id="csvaba">
			SVAs de Internet. Para ver y seleccionar servicios en este apartado debe escoger un plan de Internet.
		</div>
	</div>

	<div class="toCenter wt tac bgbox-c barra" tag="dsvatv">
		&nbsp;&nbsp;&nbsp;Selecci&oacute;n de SVA's para Televisi&oacute;n
	</div>
	<div class="toCenter wt pos-ition bgbox padbox" id="dsvatv">
		<div style="padding: 5px;background-color: white;" class="pos-ition" id="csvatv">
			SVAs de Televisi&oacute;n. Para ver y seleccionar servicios en este apartado debe escoger un plan de Televisi&oacute;n.
		</div>
	</div>

	<div class="toCenter wt tac bgbox-c barra" tag="dsvalb">
		&nbsp;&nbsp;&nbsp;Selecci&oacute;n de SVA's para L&iacute;nea B&aacute;sica
	</div>
	<div class="toCenter wt pos-ition bgbox padbox" id="dsvalb">
		<div style="padding: 5px;background-color: white;" class="pos-ition" id="csvalb">
			SVAs de L&iacute;nea. Para ver y seleccionar servicios en este apartado debe escoger un plan de L&iacute;nea B&aacute;sica.
		</div>
	</div>


	<div class="toCenter wt pos-ition bgbox padbox" id="dsvatv" style="margin-top: 1px;">
		<div style="padding: 5px 5px 1px 0;background-color: white; text-align: right;" class="pos-ition" id="csvatv">
			<img src="images/Sign.png" alt="" />
		</div>
	</div>



	<div id="Valores" class="floatBox">
		<div style="background-color:white; padding: 10px;" id="boxVal">
			<i>Seleccione departamento, municipio y estrato... [<?=$user?>]</i>
		</div>
		<div id="mailbody">
			<table width="100%">
				<body>
					<tr>
						<td></td>
					</tr>
				</body>
			</table>
		</div>
	</div>
	<input type="hidden" value="<?=$md?>" id="hmd" />
	<input type="hidden" value="<?=$es?>" id="hes" />
	<input type="hidden" value="<?=$user?>" id="hus" />
	<input type="hidden" value="<?=$CA . "|" . $E?>" id="hToken" />
	<input type="hidden" value="<?php echo $token ?>" id="pToken" />

	<div class="overlay">
		<div class="coverlay" id="overy">

		</div>
	</div>

	<div class="lateral">
		<div class="blink" onclick="window.location.href='http://nwhomepage/home/aplicativos_home/ld/inicio.asp'">Cotizador Larga Distancia</div>
		<div class="blink" onclick="window.location.href='http://iagregado/intranetva/datagrid/dbgrid/CotRetencion/index.php'">Cotizador Retenci&oacute;n</div>
		<div class="blink" onclick="window.location.href='http://iagregado/intranetva/datagrid/dbgrid/CotResidencialHistorico/index.php'">Hist&oacute;rico Cotizador Residencial</div>
		<div class="blink" onclick="window.location.href='http://nwhomepage/index.asp'">Volver a Explora</div>
		<div class="blink" onclick="window.location.href='http://nwhomepage/home/aplicativos_home/ParrillaTV/Index.html'">Parrilla TV Nacional</div>
		<div class="blink" onclick="window.location.href='http://nwhomepage/home/aplicativos_home/ParrillaTV/IndexSA.html'">Parrilla TV San Andr&eacute;s</div>
		<div class="blink" onclick="calificacionSitio();">Califica este sitio</div>
	</div>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div id="reservaSurvey" style="display: none;">
		<table width="100%" cellpadding="0" cellspacing="0" style="font-size: 14px;">
			<tr>
				<td colspan="3" align="left">
					Eval&uacute;a tu experiencia con el uso de esta aplicaci&oacute;n
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;
				</td>
				<td>
					&nbsp;
				</td>
				<td align="right" style="font-size: 10px;">
					Actual
				</td>
			</tr>

			<tr>
				<td align="left">
					Comprensi&oacute;n de la informaci&oacute;n
				</td>
				<td align="left">
					<div class="Qs">
						<div class="stars star_0" tag="q1">
						</div>
					</div>
				</td>
				<td align="right" id="prepa">
					<?php echo number_format($qs[0],1,',','.');?>
				</td>
			</tr>
			<tr>
				<td align="left">
					Funcionalidad (forma de consulta)
				</td>
				<td align="left">
					<div class="Qs">
						<div class="stars star_0" tag="q2">
						</div>
					</div>
				</td>
				<td align="right">
					<?php echo number_format($qs[1],1,',','.');?>
				</td>
			</tr>
			<tr>
				<td align="left">
					Tiempos de consulta
				</td>
				<td align="left">
					<div class="Qs">
						<div class="stars star_0" tag="q3">
						</div>
					</div>
				</td>
				<td align="right">
					<?php echo number_format($qs[2],1,',','.');?>
				</td>
			</tr>
			<tr>
				<td align="left">
					Dise&ntilde;o
				</td>
				<td align="left">
					<div class="Qs">
						<div class="stars star_0" tag="q4">
						</div>
					</div>
				</td>
				<td align="right">
					<?php echo number_format($qs[3],1,',','.');?>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<img src="pages/graficaBar.php?values=<?=$qs[0].'~'.$qs[1].'~'.$qs[2].'~'.$qs[3] ?>" alt="" />
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div class="bot fl p12" onclick="calificar();">Enviar</div>
					<div class="bot fl p12" onclick="cerrarQ();">Cancelar</div>
					<div class="cl"></div>
				</td>
			</tr>
		</table>
	</div>
	<div style="display: none;">
		<iframe id="iframeBO">
		</iframe>
	</div>
	<input type="hidden" id="hVlrDecoAdicPvr" value="8100|6807">
	<input type="hidden" id="hpsBA-ofertaMovVid-Ba10" value="2754|2623|2606|2607|2748|2750">

	<!--Scripts -->
	<script type='text/javascript' src='scripts/jQuery11.js'></script>
	<!--<script type="text/javascript" src="scripts/mailCotizador.js"></script>-->
	<script type="text/javascript" src="scripts/js-ui/jquery-ui.js"></script>
	<script type="text/javascript" src="scripts/jquery.tooltipster.js"></script>
	<script type="text/javascript" src="scripts/sentence.js"></script>

</body>
</html>