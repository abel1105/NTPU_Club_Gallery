<script>
<?php $jsonfile = file_get_contents('http://spreadsheets.google.com/feeds/list/1A5aZtVTseyrpJTXHNe_3c6k5RuEBw0gIT-RtszKMYgs/2/public/values?alt=json'); ?>
  var json = <? echo $jsonfile ?>;
  var jsondata = createdata();
  function createdata(){
    var chartData = [];
    var sessions = [];
    var percentnewsessions = [];
    for (var i=0; i < json.feed.entry.length; i++){
      percentnewsessions[i] = json.feed.entry[i].gsx$percentnewsessions.$t;
      sessions[i] = json.feed.entry[i].gsx$sessions.$t;
      chartData.push({
            title: "新訪客",
            value: Math.round(sessions[i]*Math.round(percentnewsessions[i])*0.01)
        });
      chartData.push({
            title: "舊訪客",
            value: Math.round(sessions[i]*(100-Math.round(percentnewsessions[i]))*0.01)
        });
    }

    return chartData;
  }
var chart = AmCharts.makeChart( "return_newchart", {
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
