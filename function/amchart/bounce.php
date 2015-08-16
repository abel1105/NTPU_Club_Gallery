<script>
<?php $jsonfile = file_get_contents('http://spreadsheets.google.com/feeds/list/1A5aZtVTseyrpJTXHNe_3c6k5RuEBw0gIT-RtszKMYgs/1/public/values?alt=json'); ?>
var json = <? echo $jsonfile ?>;
  var d = new Date();
  var weekday = new Array(7);
      weekday[0] = "日";
      weekday[1] = "一";
      weekday[2] = "二";
      weekday[3] = "三";
      weekday[4] = "四";
      weekday[5] = "五";
      weekday[6] = "六";
  var jsondata = createdata();

  function createdata(){
    var chartData = [];
  	var date = [];
  	var thisbounce = [];
  	var thisnewsession = [];
    var lastbounce = [];
  	var lastnewsession = [];
		for (var i=6; i < json.feed.entry.length-1; i++){
      if (i == 6){
        date[i] = weekday[d.getDay()];
        lastbounce[i] = json.feed.entry[i].gsx$bouncerate.$t;
        lastnewsession[i] = json.feed.entry[i].gsx$percentnewsessions.$t;
        thisbounce[i] = json.feed.entry[i+7].gsx$bouncerate.$t;
        thisnewsession[i] = json.feed.entry[i+7].gsx$percentnewsessions.$t;
      }else{
        date[i] = weekday[(d.getDay()+i+1)%7]; //json.feed.entry[i].gsx$date.$t;
        thisbounce[i] = json.feed.entry[i].gsx$bouncerate.$t;
        thisnewsession[i] = json.feed.entry[i].gsx$percentnewsessions.$t;
        lastbounce[i] = json.feed.entry[i-7].gsx$bouncerate.$t;
        lastnewsession[i] = json.feed.entry[i-7].gsx$percentnewsessions.$t;
      }
      chartData.push({
        year: date[i],
        lastbouncerate: Math.round(lastbounce[i]),
        lastnewsessionrate: Math.round(lastnewsession[i]),
        thisbouncerate: Math.round(thisbounce[i]),
        thisnewsessionrate: Math.round(thisnewsession[i])
      });
    }
    todaychartData = chartData[0];
    chartData.splice(0,1);
    chartData.push(todaychartData);
    return chartData;
  }
    var chart = AmCharts.makeChart("bouncechart", {
        "path": "../lib/amchart",
        "type": "serial",
        "theme": "none",
        "color": "#fff",
        "legend": {
          "useGraphSettings": true,
          "useMarkerColorForLabels": true,
          "useMarkerColorForValues": true,
          "valueText": "[[value]]%"
        },
        "dataProvider": jsondata
        ,
        "valueAxes": [{
          "autoGridCount": false,
          "gridCount": 5,
          "integersOnly": true,
          "maximum": 100,
          "minimum": 0,
          "axisAlpha": 1,
          "dashLength": 5,
          "color": "#fff",
          "position": "bottom"
        }],
        "startDuration": 0.5,
        "graphs": [{
          "balloonText": "上週彈出率:</br><span><b>[[value]]%</b></span>",
          "bullet": "round",
          "title": "上週彈出率:",
          "color": "#fff",
          "valueField": "lastbouncerate",
          "hidden": true,
          "fillAlphas": 0
        },{
          "balloonText": "上週新工作階段率:</br><span><b>[[value]]%</b></span>",
          "bullet": "round",
          "title": "上週新工作階段率:",
          "color": "#fff",
          "valueField": "lastnewsessionrate",
          "hidden": true,
          "fillAlphas": 0
        },{
          "balloonText": "彈出率:</br><span><b>[[value]]%</b></span>",
          "bullet": "round",
          "title": "彈出率:",
          "color": "#fff",
          "valueField": "thisbouncerate",
          "fillAlphas": 0
        },{
          "balloonText": "新工作階段率:</br><span><b>[[value]]%</b></span>",
          "bullet": "round",
          "title": "新工作階段率:",
          "color": "#fff",
          "valueField": "thisnewsessionrate",
          "fillAlphas": 0
        }],
        "chartCursor": {
          "cursorAlpha": 0,
          "zoomable": true
        },
        "categoryField": "year",
        "categoryAxis": {
          "gridPosition": "start",
          "axisAlpha": 0,
          "fillAlpha": 0.2,
          "fillColor": "#000000",
          "gridAlpha": 0,
          "position": "top"
        },
        "export": {
          "enabled": true,
            "position": "bottom-right"
         }
    });
</script>
