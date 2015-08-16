<script>
<?php $jsonfile = file_get_contents('http://spreadsheets.google.com/feeds/list/1A5aZtVTseyrpJTXHNe_3c6k5RuEBw0gIT-RtszKMYgs/3/public/values?alt=json'); ?>
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
  	var thissession = [];
    var lastsession = [];
    var thisday = [];
    var lastday = [];
		for (var i=6; i < json.feed.entry.length-1; i++){
      if (i == 6){
        date[i] = weekday[d.getDay()];
        lastsession[i] = json.feed.entry[i].gsx$sessions.$t;
        thissession[i] = json.feed.entry[i+7].gsx$sessions.$t;
        thisday[i] = json.feed.entry[i+7].gsx$date.$t.slice(4);
        lastday[i] = json.feed.entry[i].gsx$date.$t.slice(4);
      }else{
        date[i] = weekday[(d.getDay()+i+1)%7]; //json.feed.entry[i].gsx$date.$t;
        thissession[i] = json.feed.entry[i].gsx$sessions.$t;
        lastsession[i] = json.feed.entry[i-7].gsx$sessions.$t;
        thisday[i] = json.feed.entry[i].gsx$date.$t.slice(4);
        lastday[i] = json.feed.entry[i-7].gsx$date.$t.slice(4);
      }
      chartData.push({
        year: date[i],
        lastsession: Math.round(lastsession[i]),
        thissession: Math.round(thissession[i]),
        lastday: lastday[i],
        thisday: thisday[i]
      });
    }
    todaychartData = chartData[0];
    chartData.splice(0,1);
    chartData.push(todaychartData);
    return chartData;
  }
    var chart = AmCharts.makeChart("visitchart", {
        "path": "../lib/amchart",
        "type": "serial",
        "theme": "none",
        "color": "#fff",
        "legend": {
          "useGraphSettings": true,
          "useMarkerColorForLabels": true,
          "useMarkerColorForValues": true,
          "valueText": "[[value]]"
        },
        "dataProvider": jsondata
        ,
        "valueAxes": [{
          "autoGridCount": false,
          "gridCount": 5,
          "integersOnly": true,
          "minimum": 0,
          "axisAlpha": 1,
          "dashLength": 5,
          "color": "#fff",
          "position": "bottom"
        }],
        "startDuration": 0.5,
        "graphs": [{
          "balloonText": "[[lastday]]</br>上週訪客:</br><span><b>[[value]]</b></span>",
          "bullet": "round",
          "title": "上週訪客:",
          "color": "#fff",
          "valueField": "lastsession",
          "fillAlphas": 0
        },{
          "balloonText": "[[thisday]]</br>這週訪客:</br><span><b>[[value]]</b></span>",
          "bullet": "round",
          "title": "這週訪客:",
          "color": "#fff",
          "valueField": "thissession",
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
