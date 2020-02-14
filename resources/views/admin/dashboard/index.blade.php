@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-body" >
        <div class="container-fluid text-center">    
            <div class="row content">
                
                <div class="col-sm-10 text-center" style="height:400px;"> 
                    <h1>{{ trans('cruds.dashboard.heading') }}</h1>
                    <p>{{ trans('cruds.dashboard.heading_text') }}</p>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection