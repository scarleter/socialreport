    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
        <?php echo $websiteName.' Overview in Google';?>
      </h1>
            <ol class="breadcrumb">
                <!--<li><a href="<?= base_url() ?>overview"><i class="fa fa-dashboard"></i> Overview</a></li>-->
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title text-aqua">Auth information</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <section id="auth-button"></section>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title text-aqua">Data Selector</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Property</label>
                                        <select class="form-control" id="property">
                                            <?php 
                                                foreach($ids as $key => $value){
                                            ?>
                                                <option value="<?php echo $value;?>">
                                                    <?php echo $key;?>
                                                </option>
                                                <?
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date range button:</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                                <span>
                                          <i class="fa fa-calendar"></i> Date range picker
                                        </span>
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title text-aqua">Users Timeline</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <section id="userstimeline"></section>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title text-aqua">Pageviews Timeline</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <section id="pageviewstimeline"></section>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title text-aqua">Avg. Session Duration Timeline</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <section id="avgsessiondurationtimeline"></section>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title text-aqua">BEHAVIOR - ALL Pages</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <section id="behaviorAllPages"></section>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

            </div>
        </section>
    </div>
    <script>
        var constantObj = {
            'dateRangeStart': moment().subtract(6, 'days').format("YYYY-MM-DD"),
            'dateRangeEnd': moment().format("YYYY-MM-DD"),
            'ids': '<?php echo $defaultIds?>',
            'behaviorAllPagesMax': 30,
        };
        jQuery(function () {

            loadGoogleAnalyticsLibrary();
            //ga ready callback
            gapi.analytics.ready(function () {

                gapi.analytics.auth.authorize({
                    container: 'auth-button',
                    clientid: '<?php echo $GoogleClientID;?>',
                });

                buildModel();

                gapi.analytics.auth.on('success', function (response) {
                    googleAuthSuccessCallBack();
                });
            });

        });


        //Load the library.
        function loadGoogleAnalyticsLibrary() {
            (function (w, d, s, g, js, fjs) {
                g = w.gapi || (w.gapi = {});
                g.analytics = {
                    q: [],
                    ready: function (cb) {
                        this.q.push(cb)
                    }
                };
                js = d.createElement(s);
                fjs = d.getElementsByTagName(s)[0];
                js.src = 'https://apis.google.com/js/platform.js';
                fjs.parentNode.insertBefore(js, fjs);
                js.onload = function () {
                    g.load('analytics')
                };
            }(window, document, 'script'));
        };

        //build model
        function buildModel() {
            buildUserTimeline();
            buildPageviewsTimeline();
            buildAvgSessionDurationTimeline();
            buildBehaviorAllPages();
        };

        //build user timeline 
        function buildUserTimeline() {
            constantObj['userstimeline'] = new gapi.analytics.googleCharts.DataChart({
                reportType: 'ga',
                query: {
                    'dimensions': 'ga:date',
                    'metrics': 'ga:users',
                    'start-date': constantObj['dateRangeStart'],
                    'end-date': constantObj['dateRangeEnd'],
                },
                chart: {
                    type: 'LINE',
                    container: 'userstimeline',
                    options: {
                        width: '100%',
                        pieHole: 4 / 9
                    }
                }
            });
        }

        //build buildPageviewsTimeline
        function buildPageviewsTimeline() {
            constantObj['pageviewstimeline'] = new gapi.analytics.googleCharts.DataChart({
                reportType: 'ga',
                query: {
                    'dimensions': 'ga:date',
                    'metrics': 'ga:pageviews',
                    'start-date': constantObj['dateRangeStart'],
                    'end-date': constantObj['dateRangeEnd'],
                },
                chart: {
                    type: 'LINE',
                    container: 'pageviewstimeline',
                    options: {
                        width: '100%',
                        pieHole: 4 / 9
                    }
                }
            });
        }

        //build buildAvgSessionDuration timeline 
        function buildAvgSessionDurationTimeline() {
            constantObj['avgsessiondurationtimeline'] = new gapi.analytics.googleCharts.DataChart({
                reportType: 'ga',
                query: {
                    'dimensions': 'ga:date',
                    'metrics': 'ga:avgSessionDuration',
                    'start-date': constantObj['dateRangeStart'],
                    'end-date': constantObj['dateRangeEnd'],
                },
                chart: {
                    type: 'LINE',
                    container: 'avgsessiondurationtimeline',
                    options: {
                        width: '100%',
                        pieHole: 4 / 9
                    }
                }
            });
        }

        //build buildBehaviorAllPages 
        function buildBehaviorAllPages() {
            constantObj['behaviorAllPages'] = new gapi.analytics.googleCharts.DataChart({
                reportType: 'ga',
                query: {
                    'dimensions': 'ga:pagePath',
                    'metrics': 'ga:pageviews,ga:uniquePageviews,ga:avgTimeOnPage',
                    'start-date': constantObj['dateRangeStart'],
                    'end-date': constantObj['dateRangeEnd'],
                    'max-results': constantObj['behaviorAllPagesMax']
                },
                chart: {
                    type: 'TABLE',
                    container: 'behaviorAllPages',
                }
            });
        }

        //set timeline model
        function setTimelineModel() {
            var newIds = {
                query: {
                    ids: constantObj['ids'],
                    'start-date': constantObj['dateRangeStart'],
                    'end-date': constantObj['dateRangeEnd']
                }
            }
            constantObj['userstimeline'].set(newIds).execute();
            constantObj['pageviewstimeline'].set(newIds).execute();
            constantObj['avgsessiondurationtimeline'].set(newIds).execute();
            constantObj['behaviorAllPages'].set(newIds).execute();
        }

        //google auth success callback
        function googleAuthSuccessCallBack() {
            bindEvents();
            dateRangerPickerInit();
        };

        function dateRangerPickerInit() {
            var start = moment().subtract(6, 'days');
            var end = moment();

            //Date range confirm function
            function dateRangerConfirm(datestart, dateend) {
                constantObj['dateRangeStart'] = datestart.format("YYYY-MM-DD");
                constantObj['dateRangeEnd'] = dateend.format("YYYY-MM-DD");
                jQuery('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                setTimelineModel();
            }

            $('#daterange-btn').daterangepicker({
                    alwaysShowCalendars: true,
                    opens: 'right',
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: start,
                    endDate: end
                },
                dateRangerConfirm
            );

            dateRangerConfirm(start, end);
        }

        //bind some event here
        function bindEvents() {
            propertyChange();
        }

        //bind property select change
        function propertyChange() {
            $('#property').change(function () {
                var ids = $('#property option:selected').val();
                constantObj['ids'] = ids;
                setTimelineModel();
            });
        }
    </script>