<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Apex Sparklines Charts";
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
                $title = "Sparklines Charts";
                include('partials/page-title.php'); ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row" dir="ltr">
                                    <div class="col-md-4">
                                        <div id="spark1" class="apex-charts" data-colors="#727cf5"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="spark2" class="apex-charts" data-colors="#ffbc00"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="spark3" class="apex-charts" data-colors="#0acf97"></div>
                                    </div>
                                </div>
                                <!-- end row -->

                            </div><!-- end card body-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-3">Total Value</th>
                                                    <th>Percentage of Portfolio</th>
                                                    <th>Last 10 days</th>
                                                    <th>Volume</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="ps-3">$32,554</td>
                                                    <td>15%</td>
                                                    <td>
                                                        <div id="chart1" data-colors="#727cf5"></div>
                                                    </td>
                                                    <td>
                                                        <div id="chart5" data-colors="#727cf5"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-3">$23,533</td>
                                                    <td>7%</td>
                                                    <td>
                                                        <div id="chart2" data-colors="#0acf97"></div>
                                                    </td>
                                                    <td>
                                                        <div id="chart6" data-colors="#0acf97"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-3">$54,276</td>
                                                    <td>9%</td>
                                                    <td>
                                                        <div id="chart3" data-colors="#ffbc00"></div>
                                                    </td>
                                                    <td>
                                                        <div id="chart7" data-colors="#ffbc00"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-3">$11,533</td>
                                                    <td>2%</td>
                                                    <td>
                                                        <div id="chart4" data-colors="#fa5c7c"></div>
                                                    </td>
                                                    <td>
                                                        <div id="chart8" data-colors="#fa5c7c"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div><!-- end card -->
                    </div> <!-- end col-->
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

    <!-- Apex Chart Sparkline Demo js -->
    <script src="assets/js/pages/chart-apex-sparklines.js"></script>


</body>

</html>