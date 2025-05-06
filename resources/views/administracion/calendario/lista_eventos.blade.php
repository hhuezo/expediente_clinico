@foreach ($eventos as $evento)
    <li class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mb-1 bg-primary-transparent">
        <div class="fc-event-main text-primary">{{ date('d/m/Y', strtotime($evento->fecha_inicio)) }}
            {{ date('H:i', strtotime($evento->fecha_inicio)) }} - {{ date('H:i', strtotime($evento->fecha_final)) }}
            <br>{{ $evento->nombre_completo }}
        </div>
    </li>
@endforeach
