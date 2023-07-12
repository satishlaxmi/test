@extends('layouts.app')
@section('content')
<main class="login-form">
@if(Session::has('success'))
                  <div   class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! session('success') !!}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
               @endif
               @if(Session::has('warning'))
                  <div   class="alert {{ Session::get('alert-warning', 'alert-warning') }}">{!! session('warning') !!}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
               @endif
               @if(Session::has('notverified'))
                  <div   class="alert {{ Session::get('alert-warning', 'alert-warning') }}">{!! session('notverified') !!}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
               @endif
               @if(Session::has('message'))
                  <div  class="alert {{ Session::get('alert-warning', 'alert-warning') }}">
                    {!! session('message') !!} 
                    <div class="row">
                    </div>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
               @endif
               @if(Session::has('logout'))
                  <div  class="alert {{ Session::get('alert-class', 'alert-success') }}">
                    {!! session('logout') !!} 
                    <div class="row">
                    </div>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
               @endif
               
              
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Login</h3>
                    <div class="card-body">
                        <form method="POST" action="{{route('getuser')}}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control" name="email" required
                                    autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                                 @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('forget.password.get') }}">Reset Password</a>
                                      </label>
                                  </div>
                              </div>
                          </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-success btn-block">Signin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
