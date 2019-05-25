<?php

/* @var $this yii\web\View */
/* @var $patrimonio Patrimonio */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

?>

<table style="text-align: center;">
  <tbody>
    <tr>
      <td data-mce-style="text-align: center;">
      <div><span style="text-align: center;font-family:verdana,geneva,sans-serif;"><strong>PLANTA DE ARIDOS </strong></span></div>

      <div><span style="font-family:verdana,geneva,sans-serif;"><strong>&quot;GARZON&quot;</strong></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">Planta en San Mateo Desenboque R&iacute;o Sella km 6</span></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">Ventas Telfs: 66 36305 - Cel: 74524700</span></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">TARIJA-BOLIVIA</span></span></div>
      </td>
      
    </tr>
    <tr>
    <td>
      <p></p>
      <p><em><span style="font-family:tahoma,geneva,sans-serif;"><strong>NOTA DE ENTREGA</strong></span></em></p>

      <p>N&ordm;: <?= $venta["id_venta"]?></p>
      <br>
      <br>
      </td>
    </tr>
  </tbody>
</table>


<table border="0" cellpadding="0" cellspacing="0" height="53">
  <tbody>
  <tr>
    <td style="height:16px;">
    
      <p>Fecha: <?= $venta["fecha"]?></p>
      </td>
    </tr>
    <tr>
  <tr>
    <td style="height:16px;">
      <p>NIT/CI/PLACA: <?= $venta["placa"]?> </p>
      </td>
    </tr>
    <tr>
      <td style="height:16px;">
      <p><span style="font-size:14px;">Se&ntilde;or(es): <?= $venta["nombre"]?></span></p>
      </td>
      
    </tr>
    
  </tbody>
</table>
<br>

<div id="tabladiv">
  
    <div class="row">
      <table id="tbdetalle"  style="font-size:9pt;">
        <tr>
          <th>
            <label class="control-label" >CANT</label>
          </th>
          <th>
            <label class="control-label" >DETALLE</label>
          </th>
          <th>
            <label class="control-label" >P UNIT</label>
          </th>
          <th>
            <label class="control-label" >S TOTAL</label>
          </th>
        </tr>
        <tr>
          <td colspan="4">
            <br>
          </td>
        </tr>
        <?php 
        foreach ($materiales as $m) {
          echo "<tr>";

          //echo  "<td class='col-md-1'>".$form->field($venta, 'cantidad')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1' >".$m["cantidad"]."</td>";
          echo  "<td class='col-md-2' style='vertical-align:bottom'>".$m["nombre"]."</td>";
          $precio=$m['costo']/$m['cantidad'];
          
          echo  "<td class='col-md-1' style='vertical-align:bottom'><p align='right'>".number_format($precio,2)."</p></td>";
          
         
          //echo  "<td class='col-md-1'>".$form->field($venta, 'precio')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1'><p align='right'>".$m["costo"]."</p></td>";
          echo "</tr>";
          }
          echo "<tr><td colspan=4><br></td></tr>";
          echo "<tr><td id='tdtot' colspan=4><br></td></tr>";

          echo "<tr class='info'><td class='col-md-2' style='vertical-align:center' colspan=3><p align='right'>TOTAL Bs.</p></td><td class='col-md-1' style='vertical-align:center' ><p align='right'>".$venta["total"]."</p></td></tr>";
          echo "<tr class='info'><td class='col-md-2' style='vertical-align:right' colspan=3> <p class='monto' align='right'>CANCELADO Bs.</p></td><td class='col-md-1'><p class='monto' align='right'>".$venta["cancelado"]."</p></td></tr>";
          ?>
      </table>
    </div>
    <br>
    <br>
    
    <table >
    <tbody>
      <tr>
        <td style="text-align: center;">
       <span style="font-size:10pt;">
        <div>-------------------------------</div>Entregado</span>
        </td>
        <td style="text-align: center;">
        <span style="font-size:10pt;">
        <div>-------------------------------</div>Recibido</span></td>
      </tr>
    </tbody>
  </table>
  <br>

</div>


