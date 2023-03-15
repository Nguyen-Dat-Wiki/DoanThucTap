<!DOCTYPE html>
<html lang="en">

<head>
    @include('client.layouts.head')
</head>
<!--/head-->

<body>
    @include('client.layouts.header')

    <!--/header-->
    @yield('slibar')
   
    <!--/slider-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('client.layouts.menu')
                </div>
                <div class="col-sm-9 padding-right">
                    @yield('content')

                </div>
            </div>
        </div>
    </section>

    @include('client.layouts.footer')
    <!--/Footer-->


    @include('client.layouts.script')
    
    
</body>

</html>
