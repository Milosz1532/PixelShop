function getOrdersChartData() {
	const chart1 = document.getElementById('dashboard-chart-1')
	const xValues = [
		'Styczeń',
		'Luty',
		'Marzec',
		'Kwiecień',
		'Maj',
		'Czerwiec',
		'Lipiec',
		'Sierpień',
		'Wrzesień',
		'Październik',
		'Listopad',
		'Grudzień',
	]
	const yValues = ordersInMonthData.map(item => item.orders_count)
	const chartData = {
		labels: xValues,
		datasets: [
			{
				backgroundColor: 'rgba(20,100,169,1.0)',
				borderColor: 'rgba(20,100,169,0.1)',
				data: yValues,
			},
		],
	}
	new Chart(chart1, {
		type: 'line',
		data: chartData,
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: false,
				},
			},
		},
	})
}
getOrdersChartData()

function getEmployeesChartData() {
	const chart2 = document.getElementById('dashboard-chart-2')

	const chartData = employeesOrdersData.map(item => item.orders_count)
	const chartLabels = employeesOrdersData.map(item => `${item.first_name} ${item.last_name}`)

	new Chart(chart2, {
		type: 'doughnut',
		data: {
			labels: chartLabels,
			datasets: [
				{
					label: 'Ilość zamówień',
					data: chartData,
					borderWidth: 1,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: 'bottom',
				},
			},
		},
	})
}
getEmployeesChartData()
