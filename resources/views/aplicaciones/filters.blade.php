<div>
	 <form class="needs-validation" novalidate id="form_search">
        {{ csrf_field() }}
        <input type="hidden" id="oferta_id" name="oferta_id" value="{{ $oferta->id ?? '' }}">
      <div class="form-row">
        <div class="col-md-3 mb-3">
          <label for="grado">Grado Academico</label>
            <select class="form-control" id="grado" name="grado">
                <option value="-1">Todos</option>
                @foreach($grado_academico as $grado)
                <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-3">
          <label for="edad">Edad</label>
           {{-- <input type="text" name="edad" id="edad" class="form-control"> --}}
          <div class="input-group">
            <input name="edad" id="edad" type="text" required class="form-control" placeholder="Mínima">
            <input name="edad_max" id="edad_max" type="text" required class="form-control" placeholder="Máxima">
          </div>
        </div>

        <div class="col-md-3 mb-3">
            <label for="salario">Salario aspirado</label>
            {{--<input type="text" class="form-control" id="salario" name="salario">--}}
            <div class="input-group">
              <input name="salario" id="salario" type="text" required class="form-control" placeholder="Mínimo">
              <input name="salario_max" id="salario_max" type="text" required class="form-control" placeholder="Máximo">
            </div>
        </div>
        <div class="col-md-2 mb-3">
          <button style="margin-top: 30px;" type="button" class="btn btn-primary" onclick="view_table()"><i class="fas fa-search"></i> Buscar</button>
        </div>
      </div>
       <div class="form-row">
        <div class="col-md-3 mb-3">
          <label for="pais">País</label>
            <select class="form-control" id="pais" name="pais">
                <option value="">Todos</option>
                @foreach($paises as $pais)
                <option value="{{ $pais->pais }}">{{ $pais->pais }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-3">
          <label for="provincia">Provincia</label>
            <select class="form-control" id="provincia" name="provincia">
                <option value="">Todos</option>
                @foreach($provincias as $provincia)
                <option value="{{ $provincia->provincia }}">{{ $provincia->provincia }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-3">
          <label for="ciudad">Ciudades</label>
            <select class="form-control" id="ciudad" name="ciudad">
                <option value="">Todos</option>
                @foreach($ciudades as $ciudad)
                <option value="{{ $ciudad->ciudad }}">{{ $ciudad->ciudad }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-3">
          <label for="cargo">Cargos Anteriores</label>
          <input type="text" name="cargo" id="cargo" class="form-control" placeholder="Cargo">
      </div>
      @if($vista == 'oferta')
      <div class="form-row">
          @foreach ($oferta->preguntas as $pregunta)
            <div class="col-md-3 mb-3">
                <label for="edad">{{ $pregunta->texto }}</label>
                @if ($pregunta->campo=='select')
                <select class="form-control" id="campo_{{ $pregunta->id }}" name="campo_{{ $pregunta->id }}">
                  <option value="">Todos</option>
                    @php
                        $datos = explode(",", $pregunta->respuestas)
                    @endphp
                    @foreach ($datos as $dato)
                        <option value="{{ $dato }}">{{ $dato }}</option>
                    @endforeach
                </select>
                @else
                <input type="text" name="campo_{{ $pregunta->id }}" id="campo_{{ $pregunta->id }}" class="form-control">
                @endif
            </div>
          @endforeach
      </div>
      @endif
    </form>
</div>