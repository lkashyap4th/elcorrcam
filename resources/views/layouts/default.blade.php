<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Elcorrcam | {{ $title or '' }}</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Welcome Admin</strong>
                             </span> </a>
                    </div>
                    <div class="logo-element">
                        BD
                    </div>
                </li>
                <li class="{{ Request::is( 'Sets*') ? 'active' : '' }}">
                    <a href="/sets"><i class="fa fa-th-large"></i> <span class="nav-label">Sets</span></a>
                </li>
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="#" class="logout-btn">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">

            @yield('content')

        </div>
        <div class="footer">
            <div class="pull-right">
                Content Here.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; {{ date("Y") }}
            </div>
        </div>

    </div>
</div>

<!-- Mainly scripts -->
<script src="/js/jquery-2.1.1.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="/js/inspinia.js"></script>
<script src="/js/plugins/pace/pace.min.js"></script>
<script src="/js/bootbox.min.js"></script>
<script src="/js/modalform.js"></script>

@yield('js')

<script>
    $(document).ready(function(){
        $('.logout-btn').click(function(event){
            event.preventDefault();
            modalform.dialog({
                bootbox : {
                    title: 'Are you sure you want to logout?',
                    message: ''+
                        '<form action="/logout" method="post">'+
                            '{{ csrf_field() }}'+
                        '</form>',
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-default'
                        },
                        submit: {
                            label: 'Logout',
                            className: 'btn-danger'
                        }
                    }
                },
                autofocus : false,
            });
        });
    })
</script>

</body>

</html>
