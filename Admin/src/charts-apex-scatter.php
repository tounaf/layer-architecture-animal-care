<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Apex Scatter Charts";
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
                $title = "Scatter Charts";
                include('partials/page-title.php'); ?>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Scatter (XY) Chart</h4>
                                <div dir="ltr">
                                    <div id="basic-scatter" class="apex-charts" data-colors="#39afd1,#ffbc00,#727cf5"></div>
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
                                <h4 class="header-title">Scatter Chart - Datetime</h4>
                                <div dir="ltr">
                                    <div id="datetime-scatter" class="apex-charts" data-colors="#6c757d,#ffbc00,#727cf5,#0acf97,#fa5c7c"></div>
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
                                <h4 class="header-title">Scatter - Images</h4>
                                <div dir="ltr">
                                    <div id="scatter-images" class="apex-charts scatter-images-chart" data-colors="#3b5998,#e1306c"></div>
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

    <!-- Apex Chart js -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

    <!-- Apex Chart Scatter Demo js -->
    <script src="assets/js/pages/chart-apex-scatter.js"></script>


</body>

</html>