@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <form method="POST" class="login-form-center" action="{{ route('password.reset')  }}">
                        {{ csrf_field() }}
                        <input name="token" value="{{ $token }}" type="hidden">
                        <h4><a href="<?php echo env('VALIDATEME_FE_HOST') ?>"><img src="<?php echo env('VALiDATEME_LOGO_URL');?>" height="50px" width="140px"></img></a></h4>
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" required placeholder="{{ trans('global.login_email') }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" required placeholder="{{ trans('global.login_password') }}">
                                @if($errors->has('password'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </em>
                                @endif
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                                @if($errors->has('password_confirmation'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </em>
                                @endif
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success primary-button-class px-4">
                                    {{ trans('global.reset_password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection