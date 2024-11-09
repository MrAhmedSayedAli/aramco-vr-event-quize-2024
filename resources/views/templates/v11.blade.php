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
            <input class="form-control w-auto bold is-invalid" style="color: black;background-color: gray;" type="text" id="fram-in" value="https://www.life-hospital.com"/>
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

                <a href="#" class="navbar-brand brand scrool"><span class="blue">Life-</span>Hospital</a>
            </div>

            <div id="navbar-collapse-02" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="javascript:void(0)" class="purchase">Welcome : Patient 1 </a></li>
                    <li><a href="#">Home</a></li>


                    <li><a href="#" data-toggle="modal" data-target="#report-model">Reports</a></li>

                </ul>
            </div>
            <!--end navbar -->

        </div>
        <!--end container -->

    </nav>
    <!--end nav -->
    <div class="modal fade" id="report-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Your Attending Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <ul class="list-group">
                        <li class="list-group-item">Patient 1 at 10:30 AM</li>
                        <li class="list-group-item">Patient 2 at 10:50 AM</li>
                        <li class="list-group-item">Patient 4 at 09:30 AM</li>
                        <li class="list-group-item">Patient 5 canceled</li>
                        <li class="list-group-item">Patient 6 12:30 PM</li>
                    </ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</header>
<!--end header -->

<section id="services" style="margin-top: 75px">

    <!--begin section-grey-->
    <div class="section-grey small-padding-bottom">

        <!--begin container-->
        <div class="container">

            <!--begin row-->
            <div class="row margin-bottom-30">

                <!--begin col-md-12-->
                <div class="col-md-12 text-center">
                    <h2 class="section-title">Welcome  to Our Hospital</h2>

                    <div class="separator_wrapper">
                        <i class="icon icon-star-two red"></i>
                    </div>

                    <p class="section-subtitle">There are many variations of passages of Lorem Ipsum available, but the majority<br>have suffered alteration, by injected humour, or new randomised words.</p>
                </div>
                <!--end col-md-12-->

            </div>
            <!--end row-->

            <!--begin row-->
            <div class="row">

                <!--begin col-md-12-->
                <div class="col-md-12 text-center margin-top-20 margin-bottom-40">
                    <img src="{{asset('quiz/images/midic.jpg')}}" class="width-100" alt="imac">
                </div>
                <!--end col-md-12-->

                <!--begin col-md-4-->
                <div class="col-sm-6 col-md-4 services-item wow fadeIn" data-wow-delay="0.15s">

                    <!--begin popup image -->
                    <div class="services-icon">
                        <i class="icon icon-design-pencil-rule-streamline"></i>
                    </div>
                    <!--end popup image -->

                    <!--begin service-inner-->
                    <div class="services-text">
                        <h4>Top-Notch Design</h4>
                        <p>Curabitur quas nets lacus et nulat niste iaculis etimusad nisle varius etim vitae seditum ligulase quiste net sequi.</p>
                    </div>
                    <!--end service-inner-->

                </div>
                <!--end col-md-4-->

            </div>
            <!--end container-->

        </div>
        <!--end section-grey-->

</section>
<!--end services-->

<!--begin portfolio -->
<section class="section-white portfolio-padding" id="portfolio">

    <!--begin container-->
    <div class="container">

        <!--begin row-->
        <div class="row margin-bottom-50">

            <!--begin col-md-12-->
            <div class="col-md-12 text-center">
                <h2 class="section-title">Our Latest Clinics</h2>

                <div class="separator_wrapper">
                    <i class="icon icon-star-two blue"></i>
                </div>

                <p class="section-subtitle">There are many variations of passages of Lorem Ipsum available, but the majority<br>have suffered alteration, by injected humour, or new randomised words.</p>
            </div>
            <!--end col-md-12-->

        </div>
        <!--end row-->

        <!--begin row-->
        <div class="row">

            <!--begin col-sm-4-->
            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.15s">

                <!--begin popup-gallery-->
                <div class="popup-gallery first-gallery portfolio-pic">
                    <a class="popup2" href="{{asset('quiz/images/hospital/1.jpg')}}"><img src="{{asset('quiz/images/hospital/1.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper"><i class="icon icon-cursor-move eye-icon" style="font-size: 38px;"></i></span></a>
                </div>
                <!--end popup-gallery-->

            </div>
            <!--end col-sm-4-->

            <!--begin col-sm-4-->
            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.30s">

                <!--begin popup-gallery-->
                <div class="popup-gallery first-gallery portfolio-pic">
                    <a class="popup2" href="{{asset('quiz/images/hospital/2.jpg')}}"><img src="{{asset('quiz/images/hospital/2.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper"><i class="icon icon-cursor-move eye-icon" style="font-size: 38px;"></i></span></a>
                </div>
                <!--end popup-gallery-->

            </div>
            <!--end col-sm-4-->

            <!--begin col-sm-4-->
            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.45s">

                <!--begin popup-gallery-->
                <div class="popup-gallery first-gallery portfolio-pic">
                    <a class="popup2" href="{{asset('quiz/images/hospital/3.jpg')}}"><img src="{{asset('quiz/images/hospital/3.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper"><i class="icon icon-cursor-move eye-icon" style="font-size: 38px;"></i></span></a>
                </div>
                <!--end popup-gallery-->

            </div>
            <!--end col-sm-4-->

        </div>
        <!--end row-->

        <!--begin row-->
        <div class="row">

            <!--begin col-sm-4-->
            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.60s">

                <!--begin popup-gallery-->
                <div class="popup-gallery first-gallery portfolio-pic">
                    <a class="popup2" href="{{asset('quiz/images/hospital/4.jpg')}}"><img src="{{asset('quiz/images/hospital/4.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper"><i class="icon icon-cursor-move eye-icon" style="font-size: 38px;"></i></span></a>
                </div>
                <!--end popup-gallery-->

            </div>
            <!--end col-sm-4-->

            <!--begin col-sm-4-->
            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.75s">

                <!--begin popup-gallery-->
                <div class="popup-gallery first-gallery portfolio-pic">
                    <a class="popup2" href="{{asset('quiz/images/hospital/5.jpg')}}"><img src="{{asset('quiz/images/hospital/5.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper"><i class="icon icon-cursor-move eye-icon" style="font-size: 38px;"></i></span></a>

                </div>
                <!--end popup-gallery-->

            </div>
            <!--end col-sm-4-->

            <!--begin col-sm-4-->
            <div class="col-sm-4 wow fadeIn" data-wow-delay="1s">


                <!--begin popup-gallery-->
                <div class="popup-gallery first-gallery portfolio-pic">
                    <a class="popup2" href="{{asset('quiz/images/hospital/6.jpg')}}"><img src="{{asset('quiz/images/hospital/6.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper"><i class="icon icon-cursor-move eye-icon" style="font-size: 38px;"></i></span></a>
                </div>
                <!--end popup-gallery-->

            </div>
            <!--end col-sm-4-->

        </div>
        <!--end row-->

    </div>
    <!--end container-->

</section>
<!--end portfolio-->

<!--begin blog -->
<section class="section-white" id="blog">

    <!--begin container-->
    <div class="container">

        <!--begin row-->
        <div class="row margin-bottom-50">

            <!--begin col-md-12-->
            <div class="col-md-10 col-md-offset-1 text-center">
                <h2 class="section-title">Our Latest Medical News</h2>

                <div class="separator_wrapper">
                    <i class="icon icon-star-two blue"></i>
                </div>

                <p class="section-subtitle">There are many variations of passages of Lorem Ipsum available, but the majority<br>have suffered alteration, by injected humour, or new randomised words.</p>
            </div>
            <!--end col-md-12-->

        </div>
        <!--end row-->

        <!--begin row-->
        <div class="row">

            <!--begin col-sm-4 -->
            <div class="col-sm-4">

                <!--begin blog-item -->
                <div class="blog-item">

                    <!--begin popup image -->
                    <div class="popup-wrapper">
                        <div class="popup-gallery">
                            <a href="#"><img src="{{asset('quiz/images/hospital/2.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper2"><i class="icon icon-link eye-icon"></i></span></a>
                        </div>
                    </div>
                    <!--begin popup image -->

                    <!--begin blog-item_inner -->
                    <div class="blog-item-inner">

                        <h3 class="blog-title"><a href="#">Our New Clinics</a></h3>

                        <p>Quis autem velis etis reprehender etims quiste voluptate velite esse quam nihil etsa illum sedit consequatur quias quiste varias netsum.</p>

                        <a href="#" class="btn btn-lg btn-small-blue scrool">Read More!</a>

                    </div>
                    <!--end blog-item-inner -->

                </div>
                <!--end blog-item -->

            </div>
            <!--end col-sm-4-->

            <!--begin col-sm-4 -->
            <div class="col-sm-4">

                <!--begin blog-item -->
                <div class="blog-item">

                    <!--begin popup image -->
                    <div class="popup-wrapper">
                        <div class="popup-gallery">
                            <a href="#"><img src="{{asset('quiz/images/hospital/5.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper2"><i class="icon icon-link eye-icon"></i></span></a>
                        </div>
                    </div>
                    <!--begin popup image -->

                    <!--begin blog-item_inner -->
                    <div class="blog-item-inner">

                        <h3 class="blog-title"><a href="#">Doctors News</a></h3>

                        <p>Quis autem velis etis reprehender etims quiste voluptate velite esse quam nihil etsa illum sedit consequatur quias quiste varias netsum.</p>

                        <a href="#" class="btn btn-lg btn-small-blue scrool">Read More!</a>

                    </div>
                    <!--end blog-item-inner -->

                </div>
                <!--end blog-item -->

            </div>
            <!--end col-sm-4-->

            <!--begin col-sm-4 -->
            <div class="col-sm-4">

                <!--begin blog-item -->
                <div class="blog-item">

                    <!--begin popup image -->
                    <div class="popup-wrapper">
                        <div class="popup-gallery">
                            <a href="#"><img src="{{asset('quiz/images/hospital/7.jpg')}}" class="width-100" alt="pic"><span class="eye-wrapper2"><i class="icon icon-link eye-icon"></i></span></a>
                        </div>
                    </div>
                    <!--begin popup image -->

                    <!--begin blog-item_inner -->
                    <div class="blog-item-inner">

                        <h3 class="blog-title"><a href="#">Hope and life</a></h3>

                        <p>Quis autem velis etis reprehender etims quiste voluptate velite esse quam nihil etsa illum sedit consequatur quias quiste varias netsum.</p>

                        <a href="#" class="btn btn-lg btn-small-blue scrool">Read More!</a>

                    </div>
                    <!--end blog-item-inner -->

                </div>
                <!--end blog-item -->

            </div>
            <!--end col-sm-4-->

        </div>
        <!--end row-->

    </div>
    <!--end container-->

</section>
<!--end blog -->


<!--begin footer -->
<div class="footer" style="padding: 20px">

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

<script type="text/javascript">
    $(window).load(function() {
        "use strict";


    });
</script>


</body>

</html>
