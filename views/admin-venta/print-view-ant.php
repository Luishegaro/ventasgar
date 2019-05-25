<?php

/* @var $this yii\web\View */
/* @var $patrimonio Patrimonio */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

?>

<table height="157" width="533">
  <tbody>
    <tr>
      <td data-mce-style="text-align: center;" style="text-align: center;" width="321">
      <div><span style="font-family:verdana,geneva,sans-serif;"><strong>PLANTA DE ARIDOS </strong></span></div>

      <div><span style="font-family:verdana,geneva,sans-serif;"><strong>&quot;GARZON&quot;</strong></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">Planta en San Mateo Desenboque R&iacute;o Sella km 6</span></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">Ventas Telfs: 66 36305 - Cel: 74524700</span></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">TARIJA-BOLIVIA</span></span></div>
      </td>
      <td width="284">

      <p><em><span style="font-family:tahoma,geneva,sans-serif;"><strong>NOTA DE ENTREGA</strong></span></em></p>

      <p>N&ordm;: <?= $venta["numero"]?></p>

      <p>FECHA: <?= $venta["fecha"]?></p>
      </td>
    </tr>
  </tbody>
</table>
<p></p>

<table border="0" cellpadding="0" cellspacing="0" height="53" width="528">
  <tbody>
    <tr>
      <td style="width:360px;height:16px;">
      <p><span style="font-size:14px;">Se&ntilde;or(es): <?= $venta["nombre"]?></span></p>
      </td>
      <td style="width:339px;height:16px;">
      <p><strong>NIT/CI/PLACA: </strong> <?= $venta["placa"]?> </p>
      </td>
    </tr>
  </tbody>
</table>

<div class="patrimonio-view">
  
    <div class="row">
      <table id="tbdetalle">
        <col width="50">
        <col width="200">
        <tr>
          <th>
            <label class="control-label" >CANT.</label>
          </th>
          <th>
            <label class="control-label" >DETALLE</label>
          </th>
          <th>
            <label class="control-label" >P. UNIT. (Bs)</label>
          </th>
          <th>
            <label class="control-label" >P. TOTAL (Bs)</label>
          </th>
        </tr> 
        <?php $total=0; 
        foreach ($materiales as $m) {
          $total=$total+$m["costo"];

          echo "<tr>";
          //echo  "<td class='col-md-1'>".$form->field($venta, 'cantidad')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1' ><p align='right'>".$m["cantidad"]."</p></td>";
          echo  "<td class='col-md-2' style='vertical-align:bottom'><p > ".$m["nombre"]."</p></td>";
          
          echo  "<td class='col-md-1' style='vertical-align:bottom'><p align='right'>".$m["precio"]."</p></td>";
         
          //echo  "<td class='col-md-1'>".$form->field($venta, 'precio')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1'><p align='right'>".$m["costo"]."</p></td>";
          echo "</tr>";
          } 
          echo "<tr class='info'><td class='col-md-2' style='vertical-align:center' colspan=3><p align='right'>TOTAL Bs.</p></td><td class='col-md-1' style='vertical-align:center' ><p align='right'>".$total."</p></td></tr>";

          echo "<tr class='info'><td class='col-md-2' style='vertical-align:right' colspan=3> <p class='monto' align='right'>CANCELADO Bs.</p></td><td class='col-md-1'><p class='monto' align='right'>".$venta["cancelado"]."</p></td></tr>";
          ?>
      </table>
    </div>
    <p></p>
    <p></p> 
    <table  style="width: 500px;">
    <tbody>
      <tr>
        <td style="text-align: center;">
       
        <div>-------------------------------</div>Entrege conforme
        </td>
        <td style="text-align: center;">
        <div>-------------------------------</div>Recibi conforme</td>
      </tr>
    </tbody>
  </table>

</div>


