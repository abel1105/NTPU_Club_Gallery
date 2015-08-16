<script>
var data = createtopdata();
function createtopdata(){
  var chartData = [];
  <? while ($row_result_func16 = mysql_fetch_row($result_func16)){ ?>
  chartData.push({
    "club": "<? echo $row_result_func16[1] ?>",
    "photo": <? echo $row_result_func16[0] ?>
  });
  <? } ?>
  return chartData;
}
var chart = AmCharts.makeChart("topchart", {
  "type": "pie",
  "labelsEnabled": false,
  "theme": "none",
  "color": "#fff",
  "legend":{
   	"position": "bottom",
    "autoMargins":true,
    "color": "#fff",
    "valueText": "[[value]] 張"
  },
  "innerRadius": "30%",
  "defs": {
    "filter": [{
      "id": "shadow",
      "width": "200%",
      "height": "200%",
      "feOffset": {
        "result": "offOut",
        "in": "SourceAlpha",
        "dx": 0,
        "dy": 0
      },
      "feGaussianBlur": {
        "result": "blurOut",
        "in": "offOut",
        "stdDeviation": 5
      },
      "feBlend": {
        "in": "SourceGraphic",
        "in2": "blurOut",
        "mode": "normal"
      }
    }]
  },
  "dataProvider": data,
  "valueField": "photo",
  "titleField": "club",
  "export": {
    "enabled": true
  }
});

</script>
