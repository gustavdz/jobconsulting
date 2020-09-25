<form id="formulario" class="form-horizontal">
     {{ csrf_field() }}
     <div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="nombres">Nombre y Apellidos</label>
			    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="" value="">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="correo">Correo</label>
			    <input type="email" class="form-control" id="correo" name="correo" placeholder="" value="">
			</div>
     	</div>
     </div>

     <div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="nombres">Teléfono</label>
			    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="" value="">
			</div>
     	</div>
     	<div class="col">
     		
     	</div>
     </div>


    <div class="d-block text-left card-footer">
                <a href="javascript:void(0);" class="btn-wide btn btn-success">Guardar</a>
    </div>  
</form>