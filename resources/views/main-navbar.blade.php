<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
    <img src="{{ asset('images/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
    {{ config('app.name') }}
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarColor01">

    @if(Auth::check())
    <ul class="navbar-nav mr-auto">
       <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('user.attraction.index') }}"> <i class="fas fa-map-marker-alt"></i> My Submissions
          </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"></i> {{ Auth::user()->fullname }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a>
           {!! Form::open(['url' => route('logout'), 'method' => 'post', 'class' => 'd-none', 'id' => 'logout-form']) !!}
            {!! Form::close()  !!}
            <a class="dropdown-item logout" href="#">Logout</a>
        </div>
      </li>
    </ul>
    @else
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-white" href="#" data-toggle="modal" data-target="#login"> <i class="fas fa-sign-in-alt"></i> Sign in
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  text-white" href="#"  data-toggle="modal" data-target="#register"> <i class="fas fa-pencil-alt"></i> Create a new account
          </a>
        </li>
      </ul>
    @endif


  </div>
  </div>
</nav>





@if(Auth::guest())
    @push('modals')
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="register-title">Create an account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {!! Form::open(['url' => route('guest.register'), 'method' => 'POST','class' => 'ajax']) !!}
          <div class="modal-body">

            <div class="row">
                <div class="col">
                    {!! Form::bsText('firstname', 'First Name', null, ['class' => 'form-control form-control-sm']) !!}
                </div>
                <div class="col">
                  {!! Form::bsText('lastname', 'Last Name', null, ['class' => 'form-control form-control-sm']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {!! Form::bsText('username', 'Desired Username', null, ['class' => 'form-control form-control-sm']) !!}
                </div>
                <div class="col">
                   {!! Form::bsText('email', 'Email Address', null, ['class' => 'form-control form-control-sm']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    {!! Form::bsSelect('gender', 'Gender', ['' => '', 'male' => 'Male', 'female' => 'Female'], null, ['class' => 'form-control form-control-sm']) !!}
                </div>
                <div class="col">
                    {!! Form::bsText('contact_number', 'Contact Number', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'eg. 09233887588']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col">
                    {!! Form::bsPassword('password', 'Desired Password', ['class' => 'form-control form-control-sm']) !!}
                </div>
                <div class="col">
                    {!! Form::bsPassword('password_confirmation', 'Password, Again', ['class' => 'form-control form-control-sm']) !!}
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Sign up!</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="register-title" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="register-title">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['url' => route('guest.login'), 'method' => 'POST','class' => 'ajax']) !!}
                    <div class="modal-body">
                        {!! Form::bsText('username', 'Username') !!}
                        {!! Form::bsPassword('password', 'Password') !!}
                        <div class="text-center">
                          <button type="submit" class="btn-block btn btn-success">Log in</button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a href="{{ route('guest.auth:facebook') }}" class="text-info"><i class="fab fa-facebook-square fa-3x"></i></a>
                        <a href="{{ route('guest.auth:google') }}" class="text-danger"><i class="fab fa-google-plus-square fa-3x"></i></a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @endpush
@endif
