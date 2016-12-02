<section class="content-header">
  <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
    if($key  === 'success')
      {
      echo "<div class='alert alert-success alert-dismissible' role='alert'>
      <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
      $message.'</div>';
      }
    else
      {
      echo "<div class='alert alert-danger alert-dismissible' role='alert'>
      <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
      $message.'</div>';
      }
    }
  ?>

  <h1>
    <?php echo CHtml::link('<span class="fa fa-chevron-left"></span>', array('survey/index'), array('class'=>'btn btn-default btn-flat', 'title'=>'Back')); ?>
    <span class="fa fa-bar-chart"></span> Survey Results <small><?php echo $questionnaire->title; ?></small>
  </h1>
</section>

<section class="content">
  <div class="row" style="padding:20px;">
    
    <div class="row">
      
      <div class="col-md-4">
        <div class="info-box bg-yellow">
          <span class="info-box-icon"><i class="fa fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Respondents</span>
            <span class="info-box-number"><?php echo $total_res; ?></span>
            <span class="progress-description" style="margin-top:5px;">
              Respondents who already answered the survey
            </span>
          </div><!-- /.info-box-content -->
        </div>
      </div>

      <div class="col-md-4">
        <div class="info-box bg-red">
          <span class="info-box-icon"><i class="fa fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Expected Respondents</span>
            <span class="info-box-number"><?php echo SurveyQuestionnaires::model()->getResTotal($questionnaire->respondents_type,$questionnaire->respondents_loc_type,$questionnaire->respondents_loc); ?></span>
            <span class="progress-description" style="margin-top:5px;">
               All of the respondents for this type of survey
            </span>
          </div><!-- /.info-box-content -->
        </div>
      </div>

      <div class="col-md-4">
        <div class="info-box bg-blue">
          <span class="info-box-icon"><i class="fa fa-check-square-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total No. of Answers</span>
            <span class="info-box-number"><?php echo $total_ans; ?></span>
            <span class="progress-description" style="margin-top:5px;">
              Sum of all the collected answers
            </span>
          </div><!-- /.info-box-content -->
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="box box-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title">Survey Details</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body" style="font-size:12px;">
                    <div class="table-responsive">
                      <table class="table table-hover no-margin">
                        <tbody>
                            <tr>
                              <th>Survey Title</th>
                              <td><?php echo $questionnaire->title; ?></td>
                            </tr>

                            <tr>
                              <th>Question</th>
                              <td><?php echo $questionnaire->question; ?></td>
                            </tr>

                            <tr>
                              <th>Respondents Type</th>
                              <td><?php echo SurveyQuestionnaires::model()->getResType($questionnaire->respondents_type); ?></td>
                            </tr>

                            <tr>
                              <th>Res. Location</th>
                              <td><?php echo SurveyQuestionnaires::model()->getLocation($questionnaire->respondents_loc_type, $questionnaire->respondents_loc); ?></td>
                            </tr>

                            <tr>
                              <th>Date Created</th>
                              <td><?php echo date('F d, Y g:i A', $questionnaire->date_created); ?></td>
                            </tr>

                            <tr>
                              <th>Date Updated</th>
                              <td><?php echo date('F d, Y g:i A', $questionnaire->date_updated); ?></td>
                            </tr>
                        </tbody>
                      </table>
                    </div><!-- /.table-responsive -->
                  </div><!-- /.box-body -->
            </div>
      </div>

      <div class="col-md-6">
        <div class="box box-info direct-chat">
                  <div class="box-header with-border">
                    <h3 class="box-title">Answer Options</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body" style="font-size:12px;">
                    <div class="direct-chat-messages">
                      <div class="table-responsive">
                        <table class="table table-hover no-margin">
                          <thead>
                            <tr>
                              <th width="15%">Label</th>
                              <th width="45%">Description</th>
                              <th width="20%">Score</th>
                              <th width="10%">Color</th>
                              <th width="10%" style="text-align:center;">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($answer_choices as $key=>$ans): ?>
                              <tr>
                                <td>
                                  <?php echo CHtml::link("Option ".$key, array('viewrespondents', 'q'=>$questionnaire->id, 'k'=>$key)); ?>
                                </td>
                                <td><?php echo $ans; ?></td>
                                <td><?php echo '<b style="font-size:120%">'.$scores[$key].'</b> /'.$total_ans.' <small><i>'.$percentage[$key].'%</i></small>'; ?></td>
                                <td><span class="label" style="background-color:<?php echo $answer_colors[$key]; ?>"> . </span></td>
                                <td>
                                  <a href="<?php echo Yii::app()->createUrl('admin/survey/summary',  array('q'=>$questionnaire->id, 'k'=>$key)); ?>" style="margin-right:5px;" data-original-title="View Summary" data-toggle="tooltip"><i class="fa fa-search"></i></a>
                                  <a href="<?php echo Yii::app()->createUrl('admin/survey/viewrespondents', array('q'=>$questionnaire->id, 'k'=>$key)); ?>" data-original-title="View List of Respondents" data-toggle="tooltip"><i class="fa fa-users"></i></a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div><!-- /.table-responsive -->
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer text-center">
                    <a href="<?php echo Yii::app()->createUrl('admin/survey/fullsummary',  array('q'=>$questionnaire->id)); ?>">View Scores Summary</a>
                  </div>
            </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div id='bar-chart-data' data-datasets='[<?php echo $bar_chart_datasets; ?>]' data-labels='<?php echo $bar_chart_labels; ?>' style='display:none;'> </div>
        <div id='pd-chart-data' data-values='<?php echo $pd_chart_data; ?>' style='display:none;'> </div>
          <div class="col-md-4">
            <!-- DONUT CHART -->
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Donut Chart</h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                  <canvas id="pieChart" style="height:250px"></canvas>
              </div><!-- /.box-body -->
            </div><!-- /.box -->

          </div><!-- /.col (LEFT) -->

          <div class="col-md-4">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Bar Chart</h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChart" style="height:230px"></canvas>
                </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col (RIGHT) -->

          <div class="col-md-4">
             <!-- DONUT CHART -->
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Polar Area Chart</h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                  <canvas id="polarChart" style="height:250px"></canvas>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div>
      </div><!-- /.col-md-12 -->
    </div><!-- /.row -->

  </div>
</section><!-- /.content -->


<!-- ChartJS 1.0.1 -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/chartjs/Chart.min.js"></script>
<script>
  $(function () {
      console.log($('#bar-chart-data').data('datasets'))
      var barChartData = {
          labels: $('#bar-chart-data').data('labels'),
          datasets: $('#bar-chart-data').data('datasets'),
        };

        var pdChartData = $('#pd-chart-data').data('values');

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var pieOptions = {
          // Boolean - Whether to show labels on the scale
          scaleShowLabels: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(pdChartData, pieOptions);

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = barChartData;
        var barChartOptions = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: true,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - If there is a stroke on each bar
          barShowStroke: true,
          //Number - Pixel width of the bar stroke
          barStrokeWidth: 2,
          //Number - Spacing between each of the X value sets
          barValueSpacing: 5,
          //Number - Spacing between data sets within X values
          barDatasetSpacing: 1,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to make the chart responsive
          responsive: true,
          maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);


        var polarChartCanvas = $("#polarChart").get(0).getContext("2d");
        var polarChart = new Chart(polarChartCanvas);
        var polarChartData = pdChartData;
        var polarChartOptions = {
        //Boolean - Show a backdrop to the scale label
        scaleShowLabelBackdrop : true,
        //String - The colour of the label backdrop
        scaleBackdropColor : "rgba(255,255,255,0.75)",

        // Boolean - Whether the scale should begin at zero
        scaleBeginAtZero : true,

        //Number - The backdrop padding above & below the label in pixels
        scaleBackdropPaddingY : 2,

        //Number - The backdrop padding to the side of the label in pixels
        scaleBackdropPaddingX : 2,

        //Boolean - Show line for each value in the scale
        scaleShowLine : true,

        //Boolean - Stroke a line around each segment in the chart
        segmentShowStroke : true,

        //String - The colour of the stroke on each segement.
        segmentStrokeColor : "#fff",

        //Number - The width of the stroke value in pixels
        segmentStrokeWidth : 2,

        //Number - Amount of animation steps
        animationSteps : 100,

        //String - Animation easing effect.
        animationEasing : "easeOutBounce",

        //Boolean - Whether to animate the rotation of the chart
        animateRotate : true,

        //Boolean - Whether to animate scaling the chart from the centre
        animateScale : false,

        //String - A legend template
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",

        responsive: true,
        maintainAspectRatio: true

        }

        polarChartOptions.datasetFill = false;
        polarChart.PolarArea (polarChartData, polarChartOptions);


      });
</script>