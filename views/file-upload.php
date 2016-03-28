<br>
<br>
<br>
<br>  
<div class="col-md-12">
        <br><br>
        <div class="col-md-8 pull-left">
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary btn-blue btn-sm" data-title="Edit" data-toggle="modal" data-target="#new" style="margin-bottom:-8px!important;"><i class="fa fa-plus"></i>  Agregar movimiento</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-success btn-green btn-sm" data-toggle="modal" data-target="#excel" style="margin-bottom:-8px!important;"><i class="fa fa-file-excel-o"></i>
              Importar datos </button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-danger btn-red btn-sm" style="margin-bottom:-8px!important;"><i class="fa fa-trash"></i> Eliminar movimiento</button>
              </div>
          </div>
        </div>
</div>
   <div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header modal-header-verde">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading"><i class="fa fa-file-excel-o"></i>
  Importar datos desde excel </h4>
      </div>
          <div class="modal-body">
          <br>
          <!-- <div class="form group row"> -->
            <form method="post" name="upload" action="ajax.php?c=conciliacion&f=upload_file" id="upload" enctype="multipart/form-data">
                <div class="col-lg-12">
                  <input id="fileToUpload" type="file" name="fileToUpload" class="file" data-preview-file-type="text">
                  <div id=" errorblock" class="help-block"></div>
                </div>
            </form>
<!--           </div>
 -->          <span style="color:#808080">*Seleccione el archivo que desea subir, solo se permiten extenciones(.csv,.xlsx,xlsm,xls)*</span>

          </div>
                <div class="modal-footer ">
<!--                     <button type="button" class="btn btn-success" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>  subir archivo</button>
 -->                </div>
            </div>
        <!-- /.modal-content --> 
        </div>
    <!-- /.modal-dialog --> 
    </div>
<script src="./js/prueba.js"></script>
