<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Apex Mixed Charts";
    include('partials/title-meta.php'); ?>

    <?php include('partials/head-css.php'); ?>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <?php include('partials/topbar.php'); ?>

        <?php include('partials/sidenav.php'); ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">

            <div class="page-container">

                <?php
                $subtitle = "Apex";
                $title = "Mixed Charts";
                include('partials/page-title.php'); ?>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Line & Column Chart</h4>
                                <div dir="ltr">
                                    <div id="line-column-mixed" class="apex-charts" data-colors="#727cf5,#0acf97"></div>
                                </div>
                            </div>
                            <!-- end card body-->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col-->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Multiple Y-Axis Chart</h4>
                                <div dir="ltr">
                                    <div id="multiple-yaxis-mixed" class="apex-charts" data-colors="#727cf5,#39afd1,#fa5c7c"></div>
                                </div>
                            </div>
                            <!-- end card body-->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col-->
                </div>
                <!-- end row-->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Line & Area Chart</h4>
                                <div dir="ltr">
                                    <div id="line-area-mixed" class="apex-charts" data-colors="#0acf97,#fa5c7c"></div>
                                </div>
                            </div>
                            <!-- end card body-->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col-->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Line, Column & Area Chart</h4>
                                <div dir="ltr">
                                    <div id="all-mixed" class="apex-charts" data-colors="#727cf5,#39afd1,#fa5c7c"></div>
                                </div>
                            </div>
                            <!-- end card body-->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col-->
                </div>
                <!-- end row-->

            </div> <!-- container -->

            <?php include('partials/footer.php'); ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <?php include('partials/customizer.php'); ?>

    <?php include('partials/footer-scripts.php'); ?>

    <!-- Apex Charts js -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

    <!-- Apex Chart Mixed Demo js -->
    <script src="assets/js/pages/chart-apex-mixed.js"></script>


</body>

</html>