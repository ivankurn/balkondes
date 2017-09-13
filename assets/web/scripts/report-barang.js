$(document).ready(function(){
  console.log(resultpembelian, resultpenjualan, group);
  generateChartDataSatu(resultpembelian, group);
  generateChartDataDua(resultpenjualan, group);
  generateChartDataTiga(resultpembelian, group);
  generateChartDataEmpat(resultpenjualan, group);

    // generate some random data, quite different range
    function generateChartDataSatu(data, group) {
        var chartData = [];
        var date = new Date();
        var length = resultpembelian.length;
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
                date    : keterangan,
                jumlah  : data[i]['jumlah'],
                harga 	: data[i]['harga'],
                kg 	    : data[i]['kg'],
                pcs 	: data[i]['pcs'],
            });

        }
        var chart = AmCharts.makeChart("report_pembelian", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "synchronizeGrid":true,
            "valueAxes": [{
                "id":"v1",
                "axisColor": "#29e226",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "left"
            }, {
                "id":"v2",
                "axisColor": "#FCD202",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "right"
            },{
                "id":"v3",
                "axisColor": "#c44fc6",
                "axisThickness": 2,
                "axisAlpha": 1,
				"offset": 80,
                "position": "left"
            },{
                "id":"v4",
                "axisColor": "#2218af",
                "axisThickness": 2,
                "axisAlpha": 1,
				"offset": 80,
                "position": "right"
            }, ],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#29e226",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Jumlah Pembelian",
                "valueField": "jumlah",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Total Pembelian",
                "valueField": "harga",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>Rp. [[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v3",
                "lineColor": "#c44fc6",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Berat Kain Dibeli",
                "valueField": "kg",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]] Kg</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v4",
                "lineColor": "#2218af",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Qty Barang Dibeli",
                "valueField": "pcs",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]] Pcs</b></span>",
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
        var length = resultpenjualan.length;
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
                date    : keterangan,
                jumlah  : data[i]['jumlah'],
                harga 	: data[i]['harga'],
                kg 	    : data[i]['kg'],
                pcs 	: data[i]['pcs'],
            });

        }
        var chart = AmCharts.makeChart("report_penjualan", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "synchronizeGrid":true,
            "valueAxes": [{
                "id":"v1",
                "axisColor": "#29e226",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "left"
            }, {
                "id":"v2",
                "axisColor": "#FCD202",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "right"
            },{
                "id":"v3",
                "axisColor": "#c44fc6",
                "axisThickness": 2,
                "axisAlpha": 1,
				"offset": 80,
                "position": "left"
            },{
                "id":"v4",
                "axisColor": "#2218af",
                "axisThickness": 2,
                "axisAlpha": 1,
				"offset": 80,
                "position": "right"
            }, ],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#29e226",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Jumlah Penjualan",
                "valueField": "jumlah",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Total Penjualan",
                "valueField": "harga",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>Rp. [[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v3",
                "lineColor": "#c44fc6",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Berat Kain Dijual",
                "valueField": "kg",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]] Kg</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v4",
                "lineColor": "#2218af",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Qty Barang Dijual",
                "valueField": "pcs",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]] Pcs</b></span>",
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
        var length = resultpembelian.length;
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
                date    : keterangan,
                jumlah  : data[i]['jumlah'],
                harga 	: data[i]['refund'],
                kg 	    : data[i]['kg_retur'],
                pcs 	: data[i]['pcs_retur'],
            });

        }
        var chart = AmCharts.makeChart("report_retur_pembelian", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "synchronizeGrid":true,
            "valueAxes": [{
                "id":"v1",
                "axisColor": "#29e226",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "left"
            }, {
                "id":"v2",
                "axisColor": "#FCD202",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "right"
            },{
                "id":"v3",
                "axisColor": "#c44fc6",
                "axisThickness": 2,
                "axisAlpha": 1,
				"offset": 80,
                "position": "left"
            },{
                "id":"v4",
                "axisColor": "#2218af",
                "axisThickness": 2,
                "axisAlpha": 1,
				"offset": 80,
                "position": "right"
            }, ],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#29e226",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Jumlah Retur Pembelian",
                "valueField": "jumlah",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>[[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Total Retur Pembelian",
                "valueField": "harga",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <br><b>Rp. [[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v3",
                "lineColor": "#c44fc6",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Berat Kain Diretur",
                "valueField": "kg",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <br><b>[[value]] Kg</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v4",
                "lineColor": "#2218af",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Qty Barang Diretur",
                "valueField": "pcs",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <br><b>[[value]] Pcs</b></span>",
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
	function generateChartDataEmpat(data, group) {
        var chartData = [];
        var date = new Date();
        var length = resultpenjualan.length;
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
                date    : keterangan,
                jumlah  : data[i]['jumlah'],
                harga 	: data[i]['refund'],
                kg 	    : data[i]['kg_retur'],
                pcs 	: data[i]['pcs_retur'],
            });

        }
        var chart = AmCharts.makeChart("report_retur_penjualan", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": chartData,
            "synchronizeGrid":true,
            "valueAxes": [{
                "id":"v1",
                "axisColor": "#29e226",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "left"
            }, {
                "id":"v2",
                "axisColor": "#FCD202",
                "axisThickness": 2,
                "axisAlpha": 1,
                "position": "right"
            },{
                "id":"v3",
                "axisColor": "#c44fc6",
                "axisThickness": 2,
                "axisAlpha": 1,
				"offset": 80,
                "position": "left"
            },{
                "id":"v4",
                "axisColor": "#2218af",
                "axisThickness": 2,
                "axisAlpha": 1,
				"offset": 80,
                "position": "right"
            }, ],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#29e226",
                "bullet": "round",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Jumlah Retur Penjualan",
                "valueField": "jumlah",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <br><b>[[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v2",
                "lineColor": "#FCD202",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Total Retur Penjualan",
                "valueField": "harga",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <b>Rp. [[value]]</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v3",
                "lineColor": "#c44fc6",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Berat Kain Diretur",
                "valueField": "kg",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <br><b>[[value]] Kg</b></span>",
                "fillAlphas": 0
            }, {
                "valueAxis": "v4",
                "lineColor": "#2218af",
                "bullet": "square",
                "bulletBorderThickness": 1,
                "hideBulletsCount": 30,
                "title": "Qty Barang Diretur",
                "valueField": "pcs",
                "balloonText": "<span style='font-size:13px;'>[[title]] : <br><b>[[value]] Pcs</b></span>",
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
