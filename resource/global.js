$(document).ready(function(){
	
	
	$(".common-title").tooltip();

	biao("cpu");
	biao("memory");
	biao("network");

});

function winAlert(str, callback){
	var callback = arguments[1] ? arguments[1] : function(){};
	var modal = $('#myModal');
	modal.removeClass("win-frame");
	modal.children(".modal-body").text(str);
	modal.modal({
		keyboard: true
	});
	modal.on('hidden', function (){
		callback();
	});
}

function winFrame(url, callback){
	var callback = arguments[1] ? arguments[1] : function(){};
	var modal = $('#myModal');
	modal.addClass("win-frame");
	modal.children(".modal-body").html('<iframe frameborder=0 width=530 height=300 src="'+url+'"></iframe>');
	modal.modal({
		keyboard: true
	});
	modal.on('hidden', function (){
		callback();
	});	
}

function biao(id){
	var cpu;
	cpu = new Highcharts.Chart({
		chart: {
		renderTo: id,
		type: 'spline',
		height: 220,
		marginRight: 10,
		events: {
			load: function () {

				// set up the updating of the chart each second
				var series = this.series[0];
				setInterval(function () {
					var x = (new Date()).getTime(), // current time
					y = Math.random();
					series.addPoint([x, y], true, true);
				}, 1000);
			}
		}
	},
	title: {
		text: ''
	},
	xAxis: {
		type: 'datetime',
		tickPixelInterval: 150
	},
	yAxis: {
		title: {
			text: 'Value'
		},
		plotLines: [{
			value: 0,
			width: 1,
			color: '#808080'
		}]
	},
	tooltip: {
		formatter: function () {
			return '<b>' + this.series.name + '</b><br/>' +
			Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
			Highcharts.numberFormat(this.y, 2);
		}
	},
	legend: {
		enabled: false
	},
	exporting: {
		enabled: false
	},
	series: [{
		name: '随机数据',
		color: '#058DC7',
		shadow: false,
		data: (function () {
			// generate an array of random data
				var data = [],
				time = (new Date()).getTime(),
				i;

				for (i = -19; i <= 0; i++) {
				data.push({
					x: time + i * 1000,
					y: Math.random()
				});
			}
			return data;
		})()
	}]
	});	
}

window.alert = winAlert;