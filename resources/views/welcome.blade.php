@extends('layout.layout')
@section('title', '| Online Game Tic Tac Toe')
@section('content')
    <div class="row">
        <div class="col-md-12" style="margin-top:100px">
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <div class="jumbotron jumbotron-home">
                <center><img alt="Brand" src="{!! asset('assets/img/logo.png'); !!}" height="100" width="100"></center>
                <h1 style="font-family: 'Aldrich', sans-serif; color:#fff;">
                    <center><strong>TITATU</strong></center>
                </h1>
                <p class="jumbotron-home">
                    <center>Tic-tac-toe (also known as Noughts and crosses or Xs and Os) is a paper-and-pencil game for two players, X and O, who take turns marking the spaces in a 3×3 grid. The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row wins the game. Now ready for online multiplayer.<center>
                </p>
                <p>
                    <a class="btn btn-warning" href="#" style="font-size:18px; margin-top:20px" data-toggle="modal" data-target="#signup"><b>SIGN UP »</b></a>
                    <a class="btn btn-info" href="#" style="font-size:18px; margin-top:20px" data-toggle="modal" data-target="#signin"><b>SIGN IN »</b></a>
                </p>
            </div>
        </div>
    </div>
    <div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="signUp">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="signUp">Sign Up</h4>
                </div>
                {!! Form::open(array('url' => '/register', 'method' => 'post')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', '', array('class'=>'form-control', 'placeholder'=>'Input Your Name', 'required'=>true)); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'E-mail') !!}
                        {!! Form::email('email', '', array('class'=>'form-control', 'placeholder'=>'Input Your E-mail', 'required'=>true)); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Input Your Password', 'required'=>true)); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Confirm Password') !!}
                        {!! Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Your Password', 'required'=>true)); !!}
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::submit('Register', array('class'=>"btn btn-primary"))!!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="signin" tabindex="-1" role="dialog" aria-labelledby="signIn">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="signIn">Sign In</h4>
                </div> 
                {!! Form::open(array('url' => '/login', 'method' => 'post')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('email', 'E-mail') !!}
                        {!! Form::email('email', '', array('class'=>'form-control', 'placeholder'=>'Your E-mail')); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Your Password')); !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::submit('Sign In', array('class'=>"btn btn-primary"))!!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            if(window.location.href.indexOf('#signin') != -1) {
               $('#signin').modal('show');
            } else if(window.location.href.indexOf('#signup') != -1) {
               $('#signup').modal('show');
            }
        });
    </script>
@endsection
