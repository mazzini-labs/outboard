<script>
					let myScale = Chart.Scale.extend({
					/* extensions ... */
					});
					var ctx = document.getElementById("chart").getContext('2d');
					var myChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: [<?php echo $date; ?>],
						datasets: 
						[{
							label: 'Oil',
							data: [<?php echo $data1; ?>],
							backgroundColor: 'transparent',
							//backgroundColor: 'rgba(255,99,132)',
							borderColor:'rgba(132,255,99)',
							//borderColor: 'transparent',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							//steppedLine = 'before'
							//steppedLine: true,
							yAxisID: 'bbl-y-axis'
						},
						{
							label: 'Gas',
							data: [<?php echo $data2; ?>],
							backgroundColor: 'transparent',
							borderColor:'rgba(255,99,132)',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							yAxisID: 'mcf-y-axis'	
						},
						{
							label: 'Water',
							data: [<?php echo $data3; ?>],
							backgroundColor: 'transparent',
							borderColor:'rgba(99,132,255)',
							borderWidth: 1,
							pointBackgroundColor: 'rgba(0, 0, 0, 0)',
							pointBorderColor: 'rgba(0, 0, 0, 0)',
							pointBorderWidth: 1,
							yAxisID: 'bbl-y-axis'
						}]
					},
				
					options: {
						responsive: true,
						scales: {
							xAxes: [{
								display: true,
							}],
							yAxes: [{
								id: 'bbl-y-axis',
								display: true,
								type: 'logarithmic',
								position: 'left',
								// ticks: {
								//     callback: function(label, index, labels) {
								//         return index;
								// 	},
								//  },
								scaleLabel: {
									display: true,
									labelString: 'Oil (bbl); Water (bbl)'
								}
							}, {
								id: 'mcf-y-axis',
								display: true,
								type: 'logarithmic',
								position: 'right',
								//ticks: label,
								// ticks: {
								// callback: function(label, index, labels) {
								//         return index;
								// 	},
								// }, 
								scaleLabel: {
									display: true,
									labelString: 'Gas (mcf)'
								}
							}]
							/* scales:{
								yAxes: [{
									beginAtZero: false, 
									display: true, 
									type: 'logarithmic',
								}], 
								xAxes: [{
									autoskip: true, 
									maxTicketsLimit: 20
								}]
							} */
						},
						tooltips:{mode: 'index'},
						legend:{display: true, position: 'top', labels: {fontColor: 'rgb(0,0,0)', fontSize: 16}},
						plugins: {
							zoom: {
								pan: {
								
									enabled: true,

									mode: 'x',
									// xScale0: {
									// 					max: 1e4
									// 				},
									
								},
								zoom: {			
									enabled: true,
									drag: false,
									mode: 'x',
								}
							}
						}
					}
					});
				</script>