<form id="formulario" class="form-horizontal">
     {{ csrf_field() }}
     <div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="nombres">Empresa</label>
			    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="" value="">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="correo">Fecha de inicio</label>
			    <input type="email" class="form-control" id="correo" name="correo" placeholder="" value="">
			</div>
     	</div>
     </div>

     <div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="fecha">Fecha de Terminación</label>
			    <input type="text" class="form-control" id="fecha" name="fecha" placeholder="">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="telefono">Sector</label>
			    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="">
			</div>
     	</div>
     </div>
 	
 	<div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="celular">Cargo</label>
			    <input type="text" class="form-control" id="celular" name="celular" placeholder="">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="provincia">Personal a Cargo</label>
			    <input type="text" class="form-control" id="provincia" name="provincia" placeholder="">
			</div>
     	</div>
     </div>

     <div class="row">
          <div class="col">
               <div class="form-group">
                   <label for="funciones">Funciones</label>
                   <textarea rows="5" id="funciones" name="funciones" class="form-control"></textarea>
               </div>
          </div>
     	
 	</div>


    <div class="d-block text-left card-footer">
                <a href="javascript:void(0);" class="btn-wide btn btn-success">Guardar</a>
    </div>  
</form>