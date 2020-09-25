<form id="formulario" class="form-horizontal">
     {{ csrf_field() }}
     <div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="nombres">Nombres y Apellidos</label>
			    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="" value="{{ Auth::user()->name }}">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="correo">Correo</label>
			    <input type="email" class="form-control" id="correo" name="correo" placeholder="" value="{{ Auth::user()->email }}">
			</div>
     	</div>
     </div>

     <div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="fecha">Fecha de Nacimiento</label>
			    <input type="text" class="form-control" id="fecha" name="fecha" placeholder="">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="telefono">Teléfono Convencional</label>
			    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="">
			</div>
     	</div>
     </div>
 	
 	<div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="celular">Teléfono Celular</label>
			    <input type="text" class="form-control" id="celular" name="celular" placeholder="">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="pais">País</label>
			    <input type="text" class="form-control" id="pais" name="pais" placeholder="">
			</div>
     	</div>
 	</div>

 	<div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="provincia">Provincia</label>
			    <input type="text" class="form-control" id="provincia" name="provincia" placeholder="">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="ciudad">Ciudad</label>
			    <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="">
			</div>
     	</div>
 	</div>

 	<div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="foto">Foto</label>
			    <input type="file" class="form-control" id="foto" name="foto" placeholder="">
			</div>
     	</div>
     	<div class="col">
     		
     	</div>
 	</div>

    <div class="d-block text-left card-footer">
                <a href="javascript:void(0);" class="btn-wide btn btn-success">Guardar</a>
    </div>  
</form>