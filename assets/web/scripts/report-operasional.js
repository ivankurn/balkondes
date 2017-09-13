$(document).ready(function(){
  console.log(result, group);
  generateChartDataSatu(result, group);
  generateChartDataDua(result, group);
  generateChartDataTiga(result, group);


    // generate some random data, quite different range
    function generateChartDataSatu(data, group) {
        var chartData = [];
        var date = new Date();
        var length = result.length;
        for (var i = 0; i < length; i++) {
            // we create date objects here. In your data, you can have date strings
            // and then set format of your dates using chart.dataDateFormat property,
            // however when possible, use date objects, as this will speed up chart rendering.
            var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
			  "Juli", "Agustus", "September", "Oktober", "November", "Desember"
			];
			d = new Date(data[i]['tanggal']);
			tanggal = monthNames[d.getMonth()];
			
			var keterangan = "";
			if(group == 'MONTH'){
				keterangan = tanggal+' '+data[i]['year'];
			}
			
			if(group == 'YEAR'){
				keterangan = data[i]['year'];
			}
			
			if(group == 'DAY'){
				keterangan = data[i]['tanggal'];
			}
			
            chartData.push({
                date        : keterangan,
                total 		: data[i]['total_operasional'],
            });

        }
        var chart = AmCharts.makeChart("report_total_operasional", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "synchronizeGrid":true,
            "valueAxes": [{
                "id":"v1",
                "axisColor": "#7f1a83",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "left"
            }],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#7f1a83",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Total Operasional",
                "valueField": "total",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }],
            "chartScrollbar": {},
            "chartCursor": {
                "cursorPosition": "mouse"
            },
            "categoryField": "date",
            "categoryAxis": {
                "axisColor": "#DADADA",
                "minorGridEnabled": true
            },
            "export": {
              "enabled": true,
                "position": "bottom-right"
             }
        });

        chart.addListener("dataUpdated", zoomChart);
		
        zoomChart();


          function zoomChart(){
              chart.zoomToIndexes(chart.dataProvider.length - 20, chart.dataProvider.length - 1);
          }
    }
	
	function generateChartDataDua(data, group) {
        var chartData = [];
        var date = new Date();
        var length = result.length;
        for (var i = 0; i < length; i++) {
            // we create date objects here. In your data, you can have date strings
            // and then set format of your dates using chart.dataDateFormat property,
            // however when possible, use date objects, as this will speed up chart rendering.
            var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
			  "Juli", "Agustus", "September", "Oktober", "November", "Desember"
			];
			d = new Date(data[i]['tanggal']);
			tanggal = monthNames[d.getMonth()];
			
			var keterangan = "";
			if(group == 'MONTH'){
				keterangan = tanggal+' '+data[i]['year'];
			}
			
			if(group == 'YEAR'){
				keterangan = data[i]['year'];
			}
			
			if(group == 'DAY'){
				keterangan = data[i]['tanggal'];
			}
			
            chartData.push({
                date        : keterangan,
                listrik     : data[i]['listrik'],
                air 		: data[i]['air'],
            });

        }
        var chart = AmCharts.makeChart("report_listrik_air", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "synchronizeGrid":true,
            "valueAxes": [{
                "id":"v1",
                "axisColor": "#7f1a83",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "left"
            }, {
                "id":"v2",
                "axisColor": "#FCD202",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "right"
            }],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#7f1a83",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Listrik",
                "valueField": "listrik",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Air",
                "valueField": "air",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }],
            "chartScrollbar": {},
            "chartCursor": {
                "cursorPosition": "mouse"
            },
            "categoryField": "date",
            "categoryAxis": {
                "axisColor": "#DADADA",
                "minorGridEnabled": true
            },
            "export": {
              "enabled": true,
                "position": "bottom-right"
             }
        });

        chart.addListener("dataUpdated", zoomChart);
		
        zoomChart();


          function zoomChart(){
              chart.zoomToIndexes(chart.dataProvider.length - 20, chart.dataProvider.length - 1);
          }
    }
	
	function generateChartDataTiga(data, group) {
        var chartData = [];
        var date = new Date();
        var length = result.length;
        for (var i = 0; i < length; i++) {
            // we create date objects here. In your data, you can have date strings
            // and then set format of your dates using chart.dataDateFormat property,
            // however when possible, use date objects, as this will speed up chart rendering.
            var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
			  "Juli", "Agustus", "September", "Oktober", "November", "Desember"
			];
			d = new Date(data[i]['tanggal']);
			tanggal = monthNames[d.getMonth()];
			
			var keterangan = "";
			if(group == 'MONTH'){
				keterangan = tanggal+' '+data[i]['year'];
			}
			
			if(group == 'YEAR'){
				keterangan = data[i]['year'];
			}
			
			if(group == 'DAY'){
				keterangan = data[i]['tanggal'];
			}
			
            chartData.push({
                date        : keterangan,
                karyawan    : data[i]['karyawan'],
                pajak 	    : data[i]['pajak'],
                lainlain 	: data[i]['lainlain'],
            });

        }
        var chart = AmCharts.makeChart("report_karyawan_pajak_lainlain", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "synchronizeGrid":true,
            "valueAxes": [{
                "id":"v1",
                "axisColor": "#7f1a83",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "left"
            }, {
                "id":"v2",
                "axisColor": "#FCD202",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "right"
            }, {
                "id":"v3",
                "axisColor": "#ef2222",
                "axisThickness": 2,
				"offset": 80,
                "axisAlpha": 1,
                "position": "left"
            }],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#7f1a83",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Gaji Karyawan",
                "valueField": "karyawan",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b> Kg</span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Pajak",
                "valueField": "pajak",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b> Pcs</span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v3",
                "lineColor": "#ef2222",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Lain Lain",
                "valueField": "lainlain",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b> Pcs</span>",
                "fillAlphas": 0
            }],
            "chartScrollbar": {},
            "chartCursor": {
                "cursorPosition": "mouse"
            },
            "categoryField": "date",
            "categoryAxis": {
                "axisColor": "#DADADA",
                "minorGridEnabled": true
            },
            "export": {
              "enabled": true,
                "position": "bottom-right"
             }
        });

        chart.addListener("dataUpdated", zoomChart);
		
        zoomChart();


          function zoomChart(){
              chart.zoomToIndexes(chart.dataProvider.length - 20, chart.dataProvider.length - 1);
          }
    }
});
