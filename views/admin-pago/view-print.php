<?php

use yii\helpers\Html;
use app\models\ClienteForm;

?>
<table height="157" style="text-align: center;">
  <tbody>
    <tr>
      <td data-mce-style="text-align: center;" style="text-align: center;">
      <div><span style="font-family:verdana,geneva,sans-serif;"><strong>PLANTA DE ARIDOS </strong></span></div>

      <div><span style="font-family:verdana,geneva,sans-serif;"><strong>&quot;GARZON&quot;</strong></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">Planta en San Mateo Desenboque R&iacute;o Sella km 6</span></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">Ventas Telfs: 66 36305 - Cel: 74524700</span></span></div>

      <div><span style="font-size:10px;"><span style="font-family: comic sans ms,cursive;">TARIJA-BOLIVIA</span></span></div>
      </td>
    </tr>
    <tr>
      <td>
      <hr>
      <p><em><span style="font-family:tahoma,geneva,sans-serif;"><strong>RECIBO</strong></span></em></p>

      <p>N&ordm;: <?= $model->id_pago?></p>

      <p><strong>Ingreso Bs.: </strong><?= $model->monto?></p>
      <hr>
      </td>
    </tr>
  </tbody>
</table>
<p></p>

<table border="0" cellpadding="0" cellspacing="0" height="53" width="528">
  <tbody>
  <tr>
      <td style="width:360px;height:16px;">
      <p><span style="font-size:14px;"> <p><strong>Fecha:</strong> <?= $model->fecha?></p></span></p>
      </td>
    </tr>
    <tr>
      <td style="width:360px;height:16px;">
      <p><span style="font-size:14px;"><strong>Recibí de:</strong> <?= ClienteForm::getById($model->id_cliente)->nombre ?></span></p>
      </td>
    </tr>
    
  </tbody>
</table>

<div class="pago-view" style="width:200px;">
    
    <label ><strong>Por concepto de:  </strong><br><?= $model->concepto ?></label>
   

</div>
<table border="0" cellpadding="0" cellspacing="0" height="53">
  <tbody>
    <tr>
      <td style="width:200px;height:16px;">
      <p><span style="font-size:14px;"><strong>La suma de Bs.: </strong><?php 
      $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
      $decimal=explode(".", $model["monto"]);

      echo $f->format($decimal[0])." ".$decimal[1]."/100";
      ?></span></p>
      </td>
    </tr>
    
  </tbody>
</table>
<p></p>
    <p></p>
    <p></p>
    <p></p> 
    <table >
    <tbody>
      <tr>
        <td style="text-align: center;">
       <span style="font-size:8pt;">
        <div>-------------------------------</div>Entrege conforme</span>
        </td>
        <td style="text-align: center;">
        <span style="font-size:8pt;">
        <div>-------------------------------</div>Recibi conforme</span></td>
      </tr>
    </tbody>
  </table>
