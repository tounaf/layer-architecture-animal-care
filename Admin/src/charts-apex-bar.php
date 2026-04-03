<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Apex Bar Charts";
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
                $title = "Bar Charts";
                include('partials/page-title.php'); ?>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Basic Bar Chart</h4>
                                <div dir="ltr">
                                    <div id="basic-bar" class="apex-charts" data-colors="#39afd1"></div>
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
                                <h4 class="header-title">Grouped Bar Chart</h4>
                                <div dir="ltr">
                                    <div id="grouped-bar" class="apex-charts" data-colors="#fa5c7c,#6c757d"></div>
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
                                <h4 class="header-title">Stacked Bar Chart</h4>
                                <div dir="ltr">
                                    <div id="stacked-bar" class="apex-charts" data-colors="#727cf5,#0acf97,#fa5c7c,#6c757d,#39afd1"></div>
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
                                <h4 class="header-title">100% Stacked Bar Chart</h4>
                                <div dir="ltr">
                                    <div id="full-stacked-bar" class="apex-charts" data-colors="#ffbc00,#39afd1,#6c757d,#e3eaef,#727cf5"></div>
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
                                <h4 class="header-title">Bar with Negative Values</h4>
                                <div dir="ltr">
                                    <div id="negative-bar" class="apex-charts" data-colors="#fa5c7c,#0acf97"></div>
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
                                <h4 class="header-title">Reversed Bar Chart</h4>
                                <div dir="ltr">
                                    <div id="reversed-bar" class="apex-charts" data-colors="#727cf5,#0acf97"></div>
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
                                <h4 class="header-title">Bar with Image Fill</h4>
                                <div dir="ltr">
                                    <div id="image-fill-bar" class="apex-charts" data-colors="#727cf5,#0acf97,#e3eaef"></div>
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
                                <h4 class="header-title">Custom DataLabels Bar</h4>
                                <div dir="ltr">
                                    <div id="datalables-bar" class="apex-charts" data-colors="#727cf5,#0acf97,#fa5c7c,#6c757d,#39afd1,#2b908f,#ffbc00,#90ee7e,#f48024,#212730"></div>
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
                                <h4 class="header-title">Patterned Bar Chart</h4>
                                <div dir="ltr">
                                    <div id="pattern-bar" class="apex-charts" data-colors="#727cf5,#0acf97,#fa5c7c,#39afd1"></div>
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
                                <h4 class="header-title">Bar with Markers</h4>
                                <div dir="ltr">
                                    <div id="bar-markers" class="apex-charts" data-colors="#0acf97,#fa5c7c"></div>
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

    <script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>

    <!-- Apex Chart Bar Demo js -->
    <script src="assets/js/pages/chart-apex-bar.js"></script>

</body>

</html>