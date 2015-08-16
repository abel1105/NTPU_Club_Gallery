<script>
<?php $jsonfile = file_get_contents('http://spreadsheets.google.com/feeds/list/1A5aZtVTseyrpJTXHNe_3c6k5RuEBw0gIT-RtszKMYgs/4/public/values?alt=json'); ?>
  var json = <? echo $jsonfile ?>;
  var jsondata = createdata();
  function createdata(){
    var chartData = [];
    var deviceCategory = [];
    var sessions = [];
    for (var i=0; i < json.feed.entry.length; i++){
      deviceCategory[i] = json.feed.entry[i].gsx$devicecategory.$t;
      sessions[i] = json.feed.entry[i].gsx$sessions.$t;
      if(deviceCategory[i] == 'desktop'){
        chartData.push({
          title: "電腦",
          value: Math.round(sessions[i])
        });
      }
      if(deviceCategory[i] == 'tablet'){
        chartData.push({
            title: "平板",
            value: Math.round(sessions[i])
        });
      }
      if(deviceCategory[i] == 'mobile'){
        chartData.push({
            title: "手機",
            value: Math.round(sessions[i])
        });     
      }
    }

    return chartData;
  }
var chart = AmCharts.makeChart( "devicechart", {
  "type": "pie",
  "theme": "none",
  "color": "#fff",
  "dataProvider": jsondata
  ,
  "titleField": "title",
  "valueField": "value",
  "labelRadius": 5,

  "radius": "42%",
  "innerRadius": "60%",
  "labelText": "[[title]] [[value]]",
  "export": {
    "enabled": true
  }
} );
</script>
