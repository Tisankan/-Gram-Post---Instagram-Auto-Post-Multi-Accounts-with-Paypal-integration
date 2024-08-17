<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="info-box-2 bg-purple hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">contacts</i>
            </div>
            <div class="content">
                <div class="text uc"><?=l('Account')?></div>
                <div class="number"><?=$group->profile?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-2 bg-orange hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">send</i>
            </div>
            <div class="content">
                <div class="text uc"><?=l('Total process')?></div>
                <div class="number"><?=($total->total >= 10000)?"10000+":$total->total?></div>
            </div>
        </div>

    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-2 bg-light-green hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">beenhere</i>
            </div>
            <div class="content">
                <div class="text uc"><?=l("Total success")?></div>
                <div class="number"><?=($total->success >= 10000)?"10000+":$total->success?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-2 bg-red hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">sms_failed</i>
            </div>
            <div class="content">
                <div class="text uc"><?=l("Total failure")?></div>
                <div class="number"><?=($total->failure >= 10000)?"10000+":$total->failure?></div>

            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-2 bg-blue hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">layers</i>
            </div>
            <div class="content">
                <div class="text uc"><?=l("Total processing")?></div>
                <div class="number"><?=($total->processing >= 10000)?"10000+":$total->processing?></div>
                
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-blue-grey">
                <h2 class="uc">
                    <?=l('Report by day')?>
                </h2>
            </div>
            <div class="body">
                <div class="ajax_post_by_day"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-blue-grey" style="border: 1px solid #ddd; border-bottom: none;">
                <h2 class="uc">
                    <?=l('Post')?>
                </h2>
            </div>
            <div class="body">
                <div class="post_pie_chart"></div>
            </div>
            <div class="body p0">
                <ul class="list-group">
                    <li class="list-group-item"><i class="fa fa-check col-light-green" aria-hidden="true"></i> <?=l('Success')?> <span class="badge bg-grey"><?=$post->success?></span></li>
                    <li class="list-group-item"><i class="fa fa-exclamation-circle col-red" aria-hidden="true"></i> <?=l('Failure')?> <span class="badge bg-grey"><?=$post->failure?></span></li>
                    <li class="list-group-item"><i class="fa fa-tasks col-blue" aria-hidden="true"></i> <?=l('Processing')?> <span class="badge bg-grey"><?=$post->processing?></span></li>
                    <li class="list-group-item"><i class="fa fa-repeat col-deep-purple" aria-hidden="true"></i> <?=l('Repeat')?> <span class="badge bg-grey"><?=$post->repeat?></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('.ajax_post_by_day').highcharts({
            title: {
                text: ''
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    day: '%b %e',
                },
                tickInterval: 0,
                labels: {
                    enabled: true,
                    formatter: function() { return moment(this.value).format("MMM D"); },
                }
            },
            yAxis: {
                title: ''
            },
            tooltip: {
                crosshairs: true,
                animation: true,
                shared: true,
            },
            series: [
                {
                    name: '<?=l('Post')?>',
                    data: [<?=$post_by_day?>]
                }
            ]
        });

        Analytics.Highcharts({
            element : '.post_pie_chart',
            height  : 350,
            titlex  : 'datetime',
            type    : 'pie',
            name    : '<?=l('Posts')?>',
            data    : [<?=!empty($post_pie_chart)?$post_pie_chart:""?>],
            dataLabels : {
                formatter: function() {
                    return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ Analytics.round(this.percentage,2) +'%'  : null;
                }
            }
        });
    });
    </script>