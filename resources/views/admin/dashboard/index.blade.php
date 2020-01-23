@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.dashboard.title_singular') }}
    </div>

    <div class="card-body" >
        <div class="container-fluid text-center">    
            <div class="row content">
                
                <div class="col-sm-10 text-center"> 
                    <h1 style="height:400px;">Validate Me</h1>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection