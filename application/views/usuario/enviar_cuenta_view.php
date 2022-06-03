<?php header('Content-Type: text/html; charset=UTF-8'); // http://www.gestiweb.com/?q=content/problemas-html-acentos-y-e%C3%B1es-charset-utf-8-iso-8859-1       ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>COBAEM - Datos para ingresar al sistema</title>    

</head>

<body style="background-color: #f6f6f6; -webkit-font-smoothing: antialiased;
-webkit-text-size-adjust: none; width: 100% !important; height: 100%;
line-height: 1.6;">
<table style="background-color: #f6f6f6; width: 100%;">
  <tr>
    <td></td>
    <td style="width: 100% !important; vertical-align: top;" width="600">
      <div style="max-width: 600px; margin: 0 auto; display: block;
      padding: 20px; padding: 10px !important;">
      <table style="background: #fff; border: 1px solid #e9e9e9;
      border-radius: 3px;" width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding: 20px; vertical-align: top;">
          <table  cellpadding="0" cellspacing="0">
            <tr>
              <td style="font-size: 30px; color: #fff; font-weight: 500;
              padding: 20px; text-align: right; border-radius: 3px 3px 0 0;
              background: #1ab394; vertical-align: top;">
              <img src="<?php echo base_url('assets/img/logos.png');?>" align="left" height="55" />
              <span>Activación de cuenta</span>
            </td>
          </tr>
          <tr>
            <td style="padding: 0 0 20px; vertical-align: top;">
              <h2 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
              color: #676A6C; margin: 40px 0 0; line-height: 1.2;
              font-weight: 600;font-size: 12px;">
              Estimado (a): <?php echo $UNombre; ?></h2>
            </td>
          </tr>
          <tr>
            <td style="padding: 0 0 20px; vertical-align: top;">
              Te damos la más cordial bienvenida al 
              <?php echo NOMBRE_SISTEMA; ?>, 
              en dónde podrás registrar la solicitud de apoyo 
              en línea.
            </td>
          </tr>                                
          <tr>
            <td style="padding: 0 0 20px; vertical-align: top;">
              Para continuar, presiona el siguiente botón &emsp;
              <a href="<?php echo base_url("usuario/activar/$correo_activacion/$fecha_registro_codigo"); ?>" 
               style="text-decoration: none; color: #FFF; background-color: #1ab394;
               border: solid #1ab394; border-width: 5px 10px; line-height: 2;
               font-weight: bold; text-align: center; cursor: pointer;
               display: inline-block; border-radius: 5px; text-transform: capitalize;">
               Activar cuenta
             </a>
             <br />
             ó copia y pega la siguiente liga en el navegador:
             <?php echo base_url("usuario/activar/$correo_activacion/$fecha_registro_codigo"); ?>
             
           </td>
         </tr>
         <tr>
          <td style="padding: 0 0 20px; vertical-align: top;">
            Código de activación: 
            <strong style="color:#000; font-size:20px;">                                  
              <?php echo $UCodigo_activacion; ?>
            </strong>
          </td>
        </tr>   
        <tr>
          <td style="padding: 0 0 20px; vertical-align: top;">
            <strong style="color:#000;">Nota:</strong> En caso de no realizar la confirmación de la cuenta de correo electrónico dentro un período máximo de 2 días, será eliminada y tendrás que realizar de nuevo el registro. 
          </td>
        </tr> 
        <tr>
          <td style="padding: 0 0 20px; vertical-align: top;">
            Si no realizaste este registro, puedes hacer caso 
            omiso de este mensaje de correo electrónico. Otra 
            persona puede haber escrito tu dirección de correo 
            electrónico por error. 
          </td>
        </tr>                            
      </table>                              
    </td>
  </tr>
</table>
</div>
</td>
<td></td>
</tr>
</table>

</body>
</html>