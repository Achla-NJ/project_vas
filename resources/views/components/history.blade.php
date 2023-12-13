<ul class="widget-list-content list-unstyled"> 
    @foreach ($activities as $activity) 
        <li class="widget-list-item widget-list-item-green">                            
            <h5 class="card-title">{{ $activity->user->name }}  
                {{ $activity->operation}}
                @php
                    $model =  explode("\\" , $activity->model) ; 
                    $model_name = end($model);
                    $table = $activity->model::find($activity->model_id);                        
                @endphp
                {{$model_name}}
                @if ($model_name == 'Company') 
                    ({{ $table->company_name ?? '' }})
                @endif

                @if ($model_name == 'User') 
                    ({{ $table->name ?? '' }})
                @endif
                
                at
                {{ $activity->updated_at->diffForHumans()  }}

            </h5>
        </li>     
    @endforeach
</ul>