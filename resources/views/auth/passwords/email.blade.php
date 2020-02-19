@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    @if(\Session::has('message'))
                        <p class="alert alert-info fade-message">
                            {{ \Session::get('message') }}
                        </p>
                    @endif
                    <form method="POST" class="login-form-center" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        <h4><a href="<?php echo env('VALIDATEME_FE_HOST') ?>"><img src="<?php echo env('VALiDATEME_LOGO_URL');?>" height="50px" width="140px"></img></a></h4>
                        <div class="input-group mb-3 has-feedback">
                            <input type="email" name="email" class="form-control" required="autofocus" placeholder="{{ trans('global.login_email') }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success primary-button-class px-4">
                                    {{ trans('global.reset_password') }}
                                </button>
                                <a class="btn btn-success primary-button-class" href="{{route('login')}}">Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection