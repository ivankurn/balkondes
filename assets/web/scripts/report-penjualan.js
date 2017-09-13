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
                count       : data[i]['jumlah'],
                total_price : data[i]['grand_total'],
                retur 		: data[i]['total_nominal_retur'],
            });

        }
        var chart = AmCharts.makeChart("report_omzet_retur", {
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
                "title": "Jumlah Transaksi",
                "valueField": "count",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Omzet Penjualan",
                "valueField": "total_price",
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
                diskon      : data[i]['diskon'],
                pajak 		: data[i]['pajak'],
                ongkir 		: data[i]['ongkir'],
            });

        }
        var chart = AmCharts.makeChart("report_diskon_pajak_ongkir", {
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
                "gridAlpha": 0,
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
                "title": "Diskon",
                "valueField": "diskon",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Pajak",
                "valueField": "pajak",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v3",
                "lineColor": "#ef2222",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Ongkos Kirim",
                "valueField": "ongkir",
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
                total_berat : data[i]['total_kg'],
                total_qty 	: data[i]['total_pcs'],
            });

        }
        var chart = AmCharts.makeChart("report_diskon_berat_quantity", {
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
                "title": "Total Berat",
                "valueField": "total_berat",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b> Kg</span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Total Quantity",
                "valueField": "total_qty",
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
