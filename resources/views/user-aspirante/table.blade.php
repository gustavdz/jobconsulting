<table id="tbl_aplicaciones" class="table table-bordered">
    <thead>
    <tr>
        <th>Datos del Aspirante</th>
        <th>Datos de contacto</th>
    </tr>
    </thead>
    <tbody>
    @foreach($aspirantes as $rst)
        <tr>
            <td>
                <div class="widget-content p-0">
	                <div class="widget-content-wrapper">
	                    <div class="widget-content-left mr-3">
	                        <div class="widget-content-left">
	                            <img width="50" class="rounded-circle" id="img_aspirante" src="/storage/perfil/{{ $rst->user->id  }}.jpg?{{ time() }}" alt="" class="img-thumbnail" onerror="imgError(this,'{{$rst->photo_old}}');">
	                        </div>
	                    </div>
	                    <div class="widget-content-left flex2">
	                        <div class="widget-heading">{{ $rst->user->name }}</div>
                            @foreach( $rst->aspirante_formacion as $formacion)
	                        <div class="widget-subheading opacity-7">{{ $formacion->titulo }}</div>
                            @endforeach
                            <div class="widget-subheading opacity-7"><a href="#" data-toggle="modal" data-target=".modal-aspirante" onclick="viewProfile({{ $rst->id }})">Ver Perfil</a></div>
                            <div class="widget-subheading opacity-7"><a href="/storage/cv/{{ $rst->user->id }}.pdf" target="_blank">Descargar Currículum</a></div>
                            
                            @if($rst->resume_old != '' || $rst->resume_old != null)
                            <div class="widget-subheading opacity-7"><a href="{!! str_replace('http://www.human.ec/wp-content/uploads','/storage/old_resumes',$rst->resume_old) !!}" target="_blank">Descargar Currículum (Migrado)</a></div>
                            @endif
                        </div>
	                </div>
	            </div>
            </td>
            <td>
                <b>Teléfono: </b>{{ $rst->telefono }}<br>
                <b>Celular: </b>{{ $rst->celular }}<br>
                <b>Correo: </b>{{ $rst->user->email }}<br>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>