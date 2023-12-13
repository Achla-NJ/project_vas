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
                    <x-history :activities="$activities"/>
                @else
                    <p>No updates yet</p>
                @endif
            </div>
        </div>
    </div>    
</div> 

@endsection