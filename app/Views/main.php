<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>G - Tour</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href=<?= base_url('assets/images/favicon.ico') ?>>

    <link href=<?= base_url('assets/plugins/morris/morris.css') ?> rel="stylesheet">

    <link href=<?= base_url('assets/css/bootstrap.min.css') ?> rel="stylesheet" type="text/css">
    <link href=<?= base_url('assets/css/icons.css') ?> rel="stylesheet" type="text/css">
    <link href=<?= base_url('assets/css/style.css') ?> rel="stylesheet" type="text/css">
    <link href=<?= base_url('assets/css/pembayaran.css') ?> rel="stylesheet" type="text/css">

</head>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                <i class="ion-close"></i>
            </button>

            <!-- LOGO -->
            <div class="topbar-left">
                <div class="text-center">
                    <a href="/" class="logo"><i class="mdi mdi-assistant"></i> G-Tour</a>
                    <!-- <a href="index.html" class="logo"><img src=<?= base_url('assets/images/logo.png') ?> height="24" alt="logo"></a> -->
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">

                <div id="sidebar-menu">
                    <?= $this->renderSection('menu') ?>
                    <?= $this->include('menu') ?>

                </div>
                <div class="clearfix"></div>
            </div> <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <?= $this->renderSection('isi') ?>
            </div> <!-- content -->

            <footer class="footer">
                © 2018 Annex by Mannatthemes.
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->


    <!-- jQuery  -->
    <script src=<?= base_url('assets/js/jquery.min.js') ?>></script>
    <script src=<?= base_url('assets/js/popper.min.js') ?>></script>
    <script src=<?= base_url('assets/js/bootstrap.min.js') ?>></script>
    <script src=<?= base_url('assets/js/modernizr.min.js') ?>></script>
    <script src=<?= base_url('assets/js/detect.js') ?>></script>
    <script src=<?= base_url('assets/js/fastclick.js') ?>></script>
    <script src=<?= base_url('assets/js/jquery.slimscroll.js') ?>></script>
    <script src=<?= base_url('assets/js/jquery.blockUI.js') ?>></script>
    <script src=<?= base_url('assets/js/waves.js') ?>></script>
    <script src=<?= base_url('assets/js/jquery.nicescroll.js') ?>></script>
    <script src=<?= base_url('assets/js/jquery.scrollTo.min.js') ?>></script>

    <script src=<?= base_url('assets/plugins/skycons/skycons.min.js') ?>></script>
    <script src=<?= base_url('assets/plugins/raphael/raphael-min.js') ?>></script>
    <script src=<?= base_url('assets/plugins/morris/morris.min.js') ?>></script>

    <script src=<?= base_url('assets/pages/dashborad.js') ?>></script>

    <!-- App js -->
    <script src=<?= base_url('assets/js/app.js') ?>></script>
    <script src=<?= base_url('assets/js/pembayaran.js') ?>></script>
    <script>
        /* BEGIN SVG WEATHER ICON */
        if (typeof Skycons !== 'undefined') {
            var icons = new Skycons({
                    "color": "#fff"
                }, {
                    "resizeClear": true
                }),
                list = [
                    "clear-day", "clear-night", "partly-cloudy-day",
                    "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                    "fog"
                ],
                i;

            for (i = list.length; i--;)
                icons.set(list[i], list[i]);
            icons.play();
        };

        // scroll

        $(document).ready(function() {

            $("#boxscroll").niceScroll({
                cursorborder: "",
                cursorcolor: "#cecece",
                boxzoom: true
            });
            $("#boxscroll2").niceScroll({
                cursorborder: "",
                cursorcolor: "#cecece",
                boxzoom: true
            });

        });
    </script>

</body>

</html>