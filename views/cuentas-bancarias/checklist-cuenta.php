<?php
   include './parametros_conexion.php';
?>
<br><br>
<div class="container">
  <div class="page-header">
    <h3 class="title"><i class="fa fa-calendar-check-o"></i>  Estados de cuenta</h3>
    </div>
      <div class="col-lg-4">
      <input type="hidden" id="anio" value="<?php echo $anio?>">
        <div class="form-group row">
           <label class="col-lg-2 control-label">Año:</label>
            <div class="col-lg-7">
               <select data-live-search="true" class="selectpicker show-menu-arrow" data-width="100%" id="cboanio" name="cboanio" data-size="10" onchange="busca_mes()" >
                 <option value="">-- Año --</option>
                 <option value="2015">2015</option>
                 <option value="2016">2016</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary btn-sm" onclick="cambia_año()"><i class="fa fa-search"></i>  Listar</button>
            </div>
            <div class="col-lg-1" id="loader" style="display:none;"><img src="./images/ajax-loader.gif" alt=""></div>

        </div>
      </div>
      <div class="col-lg-6 col-lg-offset-1" style="margin-top:-6%;">
        <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">  
                <strong><i class="fa fa-credit-card"></i>  Cuenta:<?php echo $num_cuenta?>/<?php echo $banco?>/<?php echo $anio?></strong>
                <input type="hidden" id="cta" value="<?php echo $id_cta?>">
            </h3>
        </div>   
        <ul class="list-group">
        <?php 
        $enlace = mysqli_connect($host,$user,$pass);
        $array_mes = array();
        $i=0;
        $li=1;
        while($mes= $meses->fetch_assoc())
        {
            $query = 'SELECT * FROM finanzas.archivo_estado where idmes_anio='.$mes['idmes_anio'].' and idcuenta='.$id_cta;
            $results = mysqli_query($enlace,$query);
            while($res= $results->fetch_assoc())
            {
               $array_mes[$i] = $res['idmes_anio'];   
               $i++;  
            ?>
               <li class="list-group-item">
                  <div class="row toggle" id="dropdown-detail-<?php echo $li?>" data-toggle="detail-<?php echo $li?>">
                      <div class="col-xs-10">
                          <span style="color:#218344;font-size:16px;"><i class="fa fa-check"></i><?php echo $mes['nombre_mes']?></span>
                      </div>
                      <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                  </div>
                  <div id="detail-<?php echo $li?>">
                      <hr></hr>
                      <div class="container">
                          <div class="fluid-row">
                              <div class="col-lg-3">
                                 <a href="/systema/finanzas/uploads/estados_cuenta/<?php echo $anio?>/<?php echo $cta?>/<?php echo $res['archivo']?>" target="_blank" onclick="window.open(this.href,this.target,'width=700,height=900,top=200,left=200,toolbar=no,location=no,status=no,menubar=no');return false;"><?php echo $res['archivo']?></a> 

                              </div>
                              <div class="col-lg-1">
                                 <a data-toggle="modal" data-mes-id="<?php echo $mes['idmes_anio']?>" title="Subir un estado de cuenta" class="open-AddBookDialog btn btn-warning btn-xs" href="#upload_file"><i class="fa fa-pencil"></i> Cambiar archivo</a>
                              </div>
                          </div>
                      </div>
                  </div>
                </li>

            <?php
            $li++;
          }
            if(in_array($mes['idmes_anio'], $array_mes))
            { }
            else
            {?>
             <li class="list-group-item">
                  <div class="row toggle" id="dropdown-detail-<?php echo $li?>" data-toggle="detail-<?php echo $li?>">
                      <div class="col-xs-10">
                          <span style="color:#8F2424;font-size:16px;"><i class="fa fa-times"></i><?php echo $mes['nombre_mes']?></span>
                      </div>
                      <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                  </div>
                  <div id="detail-<?php echo $li?>">
                      <hr></hr>
                      <div class="container">
                          <div class="fluid-row">
                              <div class="col-lg-3">
                                  Sin archivo
                              </div>
                              <div class="col-lg-1">
                                 <a data-toggle="modal" data-mes-id="<?php echo $mes['idmes_anio']?>" title="Add this item" class="open-AddBookDialog btn btn-info btn-xs" href="#upload_file"><i class="fa fa-upload"></i>  Subir archivo</a>
                              </div>
                          </div>
                      </div>
                  </div>
                </li>
            <?php }
            $li++;
            }?>
      </ul>
  </div>
  </div>
<!-- Modal para subir el archivo -->
<div class="modal fade" id="upload_file" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading" style="font-weight:bold;"><i class="fa fa-file-pdf-o"></i>
  Subir estado de cuenta </h4>
      </div>
          <div class="modal-body">
          <br>
          
            <form method="post" name="upload" action="ajax.php?c=cuentas&f=upload_estadoCta" id="upload" enctype="multipart/form-data">
                <input type="hidden" id="anioId" name="anioId" value="<?php echo $anio?>">
                <input type="hidden" id="mesId" name ="mesId">
                <input type="hidden" id="ctaId" name="ctaId" value="<?php echo $cta?>">
                <div class="col-lg-12">
                  <input id="fileToUpload" type="file" name="fileToUpload" class="file" data-preview-file-type="text">
                  <div id=" errorblock" class="help-block"></div>
                </div>
            </form>
           <span style="color:#6D2424">*Seleccione el archivo que desea subir(deberá ser extensión .pdf)*</span>
              <div id="resultados"></div>
          </div>
                <div class="modal-footer ">
               </div>
            </div>
        <!-- /.modal-content --> 
        </div>
    <!-- /.modal-dialog --> 
    </div>
    <!-- Modal Start here-->
<div class="modal fade bs-example-modal-sm" id="myPleaseWait" tabindex="-1"
    role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span class="glyphicon glyphicon-time">
                    </span>  Por favor espere...
                 </h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-info
                    progress-bar-striped active"
                    style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal ends Here -->
<script src="./js/estados-cuenta.js"></script>