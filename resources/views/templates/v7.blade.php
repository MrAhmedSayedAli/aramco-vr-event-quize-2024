<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <title>BeSmart - Startup Landing Page Template</title>

    <!-- Loading Bootstrap -->
    <link href="{{asset('quiz/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Loading Template CSS -->
    <link href="{{asset('quiz/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('quiz/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('quiz/css/style-magnific-popup.css')}}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{asset('quiz/css/fonts.css')}}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,100' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700' rel='stylesheet' type='text/css'>

    <!-- Font Favicon -->
    <link rel="shortcut icon" href="{{asset('quiz/images/favicon.ico')}}">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="{{asset('quiz/js/html5shiv.js')}}"></script>
    <script src="{{asset('quiz/js/respond.min.js')}}"></script>
    <![endif]-->

    <!--headerIncludes-->

</head>
<body>

<!--begin loader -->
<div id="loader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--end loader -->


<!--begin header -->
<header class="header">

    <!--begin nav -->
    <nav class="navbar navbar-default navbar-fixed-top">

        <div class="p-4 border border-danger">
            <input class="form-control w-auto bold is-invalid" style="color: black;background-color: gray;" type="text" id="fram-in" value="https://www.fashion-store.com"/>
        </div>

        <!--begin container -->
        <div class="container">

            <!--begin navbar -->
            <div class="navbar-header">
                <button data-target="#navbar-collapse-02" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a href="#" class="navbar-brand brand scrool"><span class="blue">Fashion-</span>Store</a>
            </div>

            <div id="navbar-collapse-02" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="javascript:void(0)" class="purchase">Login</a></li>
                    <li><a href="#home_wrapper">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#portfolio">Portfolio</a></li>
                    <li><a href="#register">Register</a></li>


                </ul>
            </div>
            <!--end navbar -->

        </div>
        <!--end container -->

    </nav>
    <!--end nav -->

</header>
<!--end header -->


<!--begin services-->
<section id="services" style="padding-top: 100px">

    <!--begin section-grey-->
    <div class="section-grey small-padding-bottom">

        <!--begin container-->
        <div class="container">

            <!--begin row-->
            <div class="row margin-bottom-30">

                <!--begin col-md-12-->

                <!--end col-md-12-->

            </div>
            <!--end row-->

            <!--begin row-->
            <div class="row">
                <!--begin col-md-12-->
                <div class="col-md-12 text-center margin-top-20 margin-bottom-40">
                    <img src="{{asset('quiz/images/es.jpg')}}" class="width-100" alt="imac">
                </div>
                <!--end col-md-12-->


            </div>
            <!--end row-->

        </div>
        <!--end container-->

    </div>
    <!--end section-grey-->

</section>
<!--end services-->



<!--begin footer -->
<div class="footer" style="padding: 20px 20px 100px;">

    <!--begin container -->
    <div class="container">

        <!--begin row -->
        <div class="row">

            <!--begin col-md-12 -->
            <div class="col-md-12 text-center">

                <!--begin footer_social -->
                <ul class="footer_social">
                    <li>
                        <a href="#">
                            <i class="icon icon-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon icon-pinterest"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon icon-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon icon-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon icon-skype"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon icon-dribble"></i>
                        </a>
                    </li>
                </ul>
                <!--end footer_social -->
                <p class="text-white p-0 mt-1" style="margin-top: 15px">Apache Tomcat/7.0.54</p>
            </div>
            <!--end col-md-6 -->

        </div>
        <!--end row -->

    </div>
    <!--end container -->

</div>
<!--end footer -->
<!-- Load JS here for greater good =============================-->
<script src="{{asset('quiz/js/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('quiz/js/bootstrap.min.js')}}"></script>
<script src="{{asset('quiz/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('quiz/js/jquery.nav.js')}}"></script>
<script src="{{asset('quiz/js/jquery.scrollTo-min.js')}}"></script>
<script src="{{asset('quiz/js/SmoothScroll.js')}}"></script>
<script src="{{asset('quiz/js/wow.js')}}"></script>
<script src="{{asset('quiz/js/custom.js')}}?=new"></script>
<script src="{{asset('quiz/js/plugins.js')}}"></script>




</body>

</html>
