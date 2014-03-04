<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{HTML::style(URL::asset('css/bootstrap.min.css'))}}
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <p class="col-md-8 col-md-offset-2">
                    {{link_to_route('admin.artists', 'Home')}}
                </p>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @yield('body')
                </div>
            </div>
        </div>
    </body>
</html>