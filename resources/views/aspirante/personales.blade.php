<form id="formulario_personal" class="form-horizontal">
     {{ csrf_field() }}
     <div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="nombres">Nombres y Apellidos</label>
			    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="" value="{{ Auth::user()->name }}">
                   <label tipo="error" id="nombres-error"></label>
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="correo">Correo</label>
			    <input type="email" class="form-control" id="correo" name="correo" placeholder="" value="{{ Auth::user()->email }}">
                   <label tipo="error" id="correo-error"></label>
			</div>
     	</div>
     </div>

     <div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="fecha">Fecha de Nacimiento</label>
			    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $aspirante->fecha_nacimiento }}" placeholder="" max="{{ date('Y-m-d') }}">
                   <label tipo="error" id="fecha-error"></label>
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="telefono">Teléfono Convencional</label>
			    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $aspirante->telefono }}" placeholder="">
                   <label tipo="error" id="telefono-error"></label>
			</div>
     	</div>
     </div>
 	
 	<div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="celular">Teléfono Celular</label>
			    <input type="text" class="form-control" id="celular" name="celular" value="{{ $aspirante->celular }}" placeholder="">
                   <label tipo="error" id="celular-error"></label>
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="pais">País</label>
			    <input type="text" class="form-control" id="pais" name="pais" value="{{ $aspirante->pais }}" placeholder="">
                   <label tipo="error" id="pais-error"></label>
			</div>
     	</div>
 	</div>

 	<div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="provincia">Provincia</label>
			    <input type="text" class="form-control" id="provincia" name="provincia" value="{{ $aspirante->provincia }}">
                   <label tipo="error" id="provincia-error"></label>
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="ciudad">Ciudad</label>
			    <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $aspirante->ciudad }}">
                   <label tipo="error" id="ciudad-error"></label>
			</div>
     	</div>
 	</div>
 	<div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="remuneracion_actual">Remuneración Actual</label>
			    <input type="text" class="form-control" id="remuneracion_actual" name="remuneracion_actual" value="{{ $aspirante->remuneracion_actual }}">
                   <label tipo="error" id="remuneracion_actual-error"></label>
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="espectativa_salarial">Expectativa Salarial</label>
			    <input type="text" class="form-control" id="espectativa_salarial" name="espectativa_salarial" value="{{ $aspirante->espectativa_salarial }}">
                   <label tipo="error" id="espectativa_salarial-error"></label>
			</div>
     	</div>
 	</div>

 	<div class="row">
     	<div class="col">
     		<div class="form-group">
			    <label for="foto">Foto</label>
			    <input type="file" class="form-control" id="foto" name="foto">
			</div>
     	</div>
     	<div class="col">
     		<div class="form-group">
			    <label for="cv">Curriculum</label>
			    <input type="file" class="form-control" id="cv" name="cv">
			</div>
     	</div>
 	</div>

    <div class="d-block text-left card-footer">
        <a href="javascript:void(0);" class="btn-wide btn btn-success" id="guardar_perfil">Guardar</a>
    </div>  
</form>