<?php
#incluye encabezado
include '../includes/top.php';?>
<link rel="stylesheet" type="text/css" href="./css/alta-cuenta.css">
<link rel="stylesheet" type="text/css" href="./css/comun-styles.css">
<link rel="stylesheet" type="text/css" href="./css/conciliacion.css">
<style type="text/css">
	.panel-body .btn:not(.btn-block) { width:140px;margin-bottom:10px;}
  .btn{font-size: 18px;text-align: center;}
</style>
<div class="container cont-principal">
	<div class="row">
	    <section>
      <br><br>
	          <!--   <div class="col-md-2">
	            	<a href="/systema/finanzas/index.php?c=financiamiento&f=consulta" class="btn btn-info btn-lg btn-panel"><i class="fa fa-money fa-2x"></i><br><br> FINANCIAMIENTO </a>
	            </div>
	            <div class="col-md-2 col-md-offset-1">
	            	<a href="/systema/finanzas/index.php?c=cuentas&f=get_movimientos" class="btn btn-primary btn-lg btn-panel" style="margin-left:18%;"><i class="fa fa-credit-card fa-2x"></i><br><br>CUENTAS</a>
	            </div>
	              <div class="col-md-2 col-md-offset-1">
	            	<a href="/systema/finanzas/index.php?c=conciliacion&f=get_conciliar" class="btn btn-info btn-lg btn-panel"><i class="fa fa-cogs fa-2x"></i><br><br> CONCILIACION </a>
	            </div>
	            <div class="col-md-2 col-md-offset-1">
	            	<a href="" class="btn btn-primary btn-lg btn-panel"><i class="fa fa-sign-out fa-2x"></i><br><br> CERRAR </a>
	            </div> -->
	            <div class="col-lg-8 col-md-offset-2" style="border-color:#2F4368;">
	             <div class="panel panel-primary">
                <div class="panel-heading" style="background: #2F4368;border-color:#2F4368; ">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-bookmark"></span> Atajos</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                    	 <div class="col-xs-6 col-md-4">
                          <a href="/systema/finanzas/index.php?c=cuentas&f=get_cuenta" class="btn btn-info btn-lg" role="button"><span class="fa fa-plus"></span> <br/>Alta cuentas</a>
                          <a href="/systema/finanzas/index.php?c=cuentas&f=get_consulta" class="btn btn-primary btn-lg" role="button"><span class="fa fa-list"></span> <br/>Ver cuentas</a>
                        </div>
                        <div class="col-xs-6 col-md-4">
                          <a href="/systema/finanzas/index.php?c=financiamiento&f=get_finan" class="btn btn-info btn-lg" role="button"><span class="glyphicon glyphicon-usd"></span> <br/>Financiar</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="fa fa-search"></span> <br/>Financiados</a>
                        </div>
                         <div class="col-xs-6 col-md-4">
                          <a href="http://localhost:8080/systema/finanzas/index.php?c=conciliacion&f=conciliacion" class="btn btn-info btn-lg" role="button"><span class=" fa fa-male"></span> <br/>Descuentos</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="fa fa-university"></span> <br/>Bancos</a>

                         </div>
                            <div class="col-xs-6 col-md-4">
                          <a href="/systema/finanzas/index.php?c=cuentas&f=get_archivos" class="btn btn-info btn-lg" role="button"><span class="fa fa-file-o"></span> <br/>Archivos</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="fa fa-transfer"></span> <br/>Conciliación</a>

                        </div>
                        <div class="col-xs-6 col-md-4">
                           <a href="/systema/finanzas/index.php?c=email&f=emails" class="btn btn-info btn-lg" role="button"><span class="fa fa-envelope"></span> <br/>Correos</a>
                         </div>
                    </div>
                </div>
                </div>
            </div>
	        </div>
	    </section>
	</div>
</div>




<?php include '../includes/footer.php';?>