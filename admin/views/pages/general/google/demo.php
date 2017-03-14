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
                    <div class="box box-info ptwBox">
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
                    <div class="box box-info ptwBox">
                        <div class="box-header">
                            <h3 class="box-title text-aqua">Data Selector</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <section id="view-selector"></section>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-info ptwBox">
                        <div class="box-header">
                            <h3 class="box-title text-aqua">Users Timeline</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <section id="timeline"></section>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>


                <!-- Step 2: Load the library. -->

                <script>
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
                </script>

                <script>
                    gapi.analytics.ready(function () {

                        gapi.analytics.auth.authorize({
                            container: 'auth-button',
                            clientid: '<?php echo $GoogleClientID;?>',
                        });

                        // Step 4: Create the view selector.

                        var viewSelector = new gapi.analytics.ViewSelector({
                            container: 'view-selector'
                        });

                        // Step 5: Create the timeline chart.

                        var timeline = new gapi.analytics.googleCharts.DataChart({
                            reportType: 'ga',
                            query: {
                                'dimensions': 'ga:date',
                                'metrics': 'ga:users',
                                'start-date': '30daysAgo',
                                'end-date': 'yesterday',
                            },
                            chart: {
                                type: 'LINE',
                                container: 'timeline',
                                options: {
                                    width: '100%',
                                    pieHole: 4 / 9
                                }
                            }
                        });

                        // Step 6: Hook up the components to work together.

                        gapi.analytics.auth.on('success', function (response) {
                            viewSelector.execute();
                        });

                        viewSelector.on('change', function (ids) {console.info(ids);
                            var newIds = {
                                query: {
                                    ids: ids,
                                    'start-date': '30daysAgo',
                                    'end-date': 'yesterday'
                                }
                            }
                            timeline.set(newIds).execute();
                        });
                    });
                </script>
            </div>
        </section>
    </div>