<!DOCTYPE html>
<html>
    <head>
        <title>Musica Api</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{HTML::style(URL::asset('css/bootstrap.min.css'))}}
        {{HTML::style(URL::asset('css/main.css'))}}
    </head>
    <body>
    <div class="page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                {{link_to_route('home', 'Musica Api',null, array('class' => "navbar-brand"))}}
                            </div>

                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>{{ link_to_route('admin.users.index','Registered Users') }}</li>
                                            <li>{{ link_to_route('admin.roles.index','Roles') }}</li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                    <li>{{ link_to_route('admin.artists','Artists') }}</li>
                                </ul>

                                <ul class="nav navbar-nav navbar-right">
                                    @if(Auth::check())
                                        <li>{{link_to_route('logout', 'Log out')}}</li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li>{{ link_to_route('account',Auth::user()->email) }}</li>
                                            </ul>
                                        </li>
                                    @else
                                        <li>{{link_to_route('register', 'Register')}}</li>
                                        <li>{{link_to_route('login', 'Log in')}}</li>
                                    @endif
                                </ul>

                            </div><!-- /.navbar-collapse -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @if(Session::has('message'))
                    <div class="alert-box success">
                        <h2>{{ Session::get('message') }}</h2>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @yield('body')
                </div>
            </div>
        </div>
    </div>
    {{HTML::script(URL::asset('js/jquery.min.js'))}}
    {{HTML::script(URL::asset('js/bootstrap.min.js'))}}
    </body>
</html>