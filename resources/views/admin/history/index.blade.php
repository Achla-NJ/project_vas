@extends('admin.layout')
@section('content')

<div class="row">
    <div class="col">
        <div class="page-description">
            <h1>Version History</h1> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card widget widget-list">
            <div class="card-header">
                
            </div>
            <div class="card-body">
                @if (count($activities) > 0)
                
                    <ul class="widget-list-content list-unstyled"> 
                        @foreach ($activities as $activity) 
                            <li class="widget-list-item widget-list-item-green">                            
                                <h5 class="card-title">{{ $activity->user->name }}  
                                    {{ $activity->operation}}
                                    @php
                                        $model =  explode("\\" , $activity->model) ; 
                                    @endphp
                                    {{ end($model) }} 
                                    at
                                    {{ $activity->updated_at->diffForHumans()  }}

                                </h5>
                            </li>     
                        @endforeach
                    </ul>
                @else
                    <p>No updates yet</p>
                @endif
            </div>
        </div>
    </div>    
</div> 

@endsection