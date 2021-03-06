<table id="tbl_aplicaciones" class="table table-bordered">
    <thead>
    <tr>
        <th>Datos del Aspirante</th>
        <th>Datos de contacto</th>
        <th>Información de postulación</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($aplicaciones as $rst)
        <tr>
            <td>
                <div class="widget-content p-0">
	                <div class="widget-content-wrapper">
	                    <div class="widget-content-left mr-3">
	                        <div class="widget-content-left">
	                            <img width="50" class="rounded-circle" id="img_aspirante" src="/storage/perfil/{{ $rst->aspirante->user->id  }}.jpg?{{ time() }}" alt="" class="img-thumbnail" onerror="imgError(this,'{{$rst->aspirante->photo_old}}');">
	                        </div>
	                    </div>
	                    <div class="widget-content-left flex2">
	                        <div class="widget-heading">{{ $rst->aspirante->user->name }}</div>
                            @foreach( $rst->aspirante->aspirante_formacion as $formacion)
	                        <div class="widget-subheading opacity-7">{{ $formacion->titulo }}</div>
                            @endforeach
                            <div class="widget-subheading opacity-7"><a href="#" data-toggle="modal" data-target=".modal-aspirante" onclick="viewProfile({{ $rst->aspirante->id }})">Ver Perfil</a></div>
                            <div class="widget-subheading opacity-7"><a href="/storage/cv/{{ $rst->aspirante->user->id }}.{{ $rst->aspirante->extension ?? 'pdf' }}" target="_blank">Descargar Currículum</a></div>
                            
                            @if($rst->aspirante->resume_old != '' || $rst->aspirante->resume_old != null)
                            <div class="widget-subheading opacity-7"><a href="{!! str_replace('http://www.human.ec/wp-content/uploads','/storage/old_resumes',$rst->aspirante->resume_old) !!}" target="_blank">Descargar Currículum (Migrado)</a></div>
                            @endif
                        </div>
	                </div>
	            </div>
            </td>
            <td>
                <b>Teléfono: </b>{{ $rst->aspirante->telefono }}<br>
                <b>Celular: </b>{{ $rst->aspirante->celular }}<br>
                <b>Correo: </b>{{ $rst->aspirante->user->email }}<br>
            </td>
            <td>
                <b>Salario Aspirado: </b>${{$rst->salario_aspirado ? $rst->salario_aspirado : '0.00'}}<br>
                <b>Fecha: </b>{{\Carbon\Carbon::parse($rst->created_at)->format('j F, Y')}}<br>
                <b>Estado: </b>{{ $rst->estado_oferta->nombre }}<br>
                @if($rst->respuesta)
                @foreach($rst->respuesta as $respuesta)
                    <b>{{ $respuesta->pregunta->texto ?? '' }}: </b>{{ $respuesta->respuesta ?? '' }}<br>
                @endforeach

                @endif
            </td>
            <td>
                @foreach ($estados as $key => $estado)
                    <div class="custom-control custom-radio">
                      <input type="radio" id="customRadio{{ $rst->id }}_{{ $key }}" name="customRadio{{ $rst->id }}" class="custom-control-input" @if($rst->estado_oferta_id == $estado->id) checked @endif onclick="changeStatus({{ $rst->id }},{{ $estado->id }})">
                      <label class="custom-control-label" for="customRadio{{ $rst->id }}_{{ $key }}">{{ $estado->nombre }}</label>
                    </div>
                    {{-- expr --}}
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>