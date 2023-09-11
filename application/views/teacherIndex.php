<!DOCTYPE html>

<html
	lang="en"
	class="light-style layout-menu-fixed"
	dir="ltr"
	data-theme="theme-default"
	data-assets-path="../assets/"
	data-template="vertical-menu-template-free"
>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<!-- Include jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<!-- Include ApexCharts -->
	<!--	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>-->

	<!-- Include FontAwesome (if not already included) -->
	<!--	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />-->

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
	<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
	<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

	<style>
		.small-text {
			font-size: 0.60em; /* Adjust the value as needed */
		}
	</style>

</head>

<body>


<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
	<div class="layout-container">
		<!-- Menu -->

		<!-- / Menu -->

		<!-- Layout container -->
		<div class="layout-page">
			<!-- Navbar -->

			<nav
				class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
				id="layout-navbar"
			>
				<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">


					<a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
						<i class="bx bx-menu bx-sm"></i>
					</a>
				</div>

				<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
					<!-- Search -->
					<div class="form-group">
						<select class="form-control" id="studentDropdown" name="studentDropdown">
							<option value="">All Students</option>
							<?php foreach ($result as $user) { ?>
								<option value="<?php echo $user->studentID; ?>">
									<?php echo $user->name . ' (' . $user->email . ')'; ?>
								</option>
							<?php } ?>
						</select>
					</div>

					<!-- /Search -->
					<ul class="navbar-nav flex-row align-items-center ms-auto">
						<!-- User -->
						<li class="nav-item navbar-dropdown dropdown-user dropdown">
							<a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
								<div class="avatar avatar-online">
									<img src="<?= $_SESSION['imgURL']? $_SESSION['imgURL']:  base_url('/assets/img/avatars/1.png')?>"  alt class="w-px-40 rounded-circle" />

								</div>
							</a>
							<ul class="dropdown-menu dropdown-menu-end">
								<li>
									<a class="dropdown-item" href="#">
										<div class="d-flex">
											<div class="flex-shrink-0 me-3">
												<div class="avatar avatar-online">
													<img src="<?=  base_url('/assets/img/avatars/1.png')?>" alt class="w-px-40 h-auto rounded-circle" />
												</div>
											</div>
											<div class="flex-grow-1">
												<span class="fw-semibold d-block"><?=$_SESSION['name']?></span>
												<small class="text-muted">Admin</small>
											</div>
										</div>
									</a>
								</li>
								<li>
									<div class="dropdown-divider"></div>
								</li>
								<li>
									<a class="dropdown-item" href="<?=base_url('index.php/welcome/userProfile')?>">
										<i class="bx bx-user me-2"></i>
										<span class="align-middle">My Profile</span>
									</a>
								</li>
								<!--							<li>-->
								<!--								<a class="dropdown-item" href="#">-->
								<!--									<i class="bx bx-cog me-2"></i>-->
								<!--									<span class="align-middle">Settings</span>-->
								<!--								</a>-->
								<!--							</li>-->

								<li>
									<div class="dropdown-divider"></div>
								</li>
								<li>
									<a class="dropdown-item" href="<?=base_url('/index.php/welcome/logout')?>">
										<i class="bx bx-power-off me-2"></i>
										<span class="align-middle">Log Out</span>
									</a>
								</li>
							</ul>
						</li>
						<!--/ User -->
					</ul>

				</div>
			</nav>

			<!-- / Navbar -->

			<!-- Content wrapper -->
			<div class="content-wrapper">
				<!-- Content -->

				<div class="container-xxl flex-grow-1 container-p-y">
					<div class="row">
						<div class="col-lg-8 mb-4 order-0">
							<div class="card">
								<div class="d-flex align-items-end row">
									<div class="col-sm-7">
										<div class="card-body">
											<h5 class="card-title text-primary"> <?= $_SESSION['name']?>! 🎉</h5>


										</div>
									</div>
									<div class="col-sm-5 text-center text-sm-left">
										<div class="card-body pb-0 px-0 px-md-4">
											<img
												src="<?= base_url('/assets/img/illustrations/man-with-laptop-light.png')?>"
												height="140"
												alt="View Badge User"
												data-app-dark-img="illustrations/man-with-laptop-dark.png"
												data-app-light-img="illustrations/man-with-laptop-light.png"
											/>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 order-1">
							<div class="row">
								<div class="col-lg-6 col-md-12 col-6 mb-4">
									<div class="card">
										<div class="card-body">
											<div class="card-title d-flex align-items-start justify-content-between">
												<div class="avatar flex-shrink-0">
													<img
														src="<?=base_url('/assets/img/icons/unicons/chart-success.png')?>"
														alt="chart success"
														class="rounded"
													/>
												</div>
												<div class="dropdown">
													<button
														class="btn p-0"
														type="button"
														id="cardOpt3"
														data-bs-toggle="dropdown"
														aria-haspopup="true"
														aria-expanded="false"
													>
														<i class="bx bx-dots-vertical-rounded"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
														<a class="dropdown-item" href="javascript:void(0);">View More</a>
														<a class="dropdown-item" href="javascript:void(0);">Delete</a>
													</div>
												</div>
											</div>
											<span class="fw-semibold d-block mb-1">Total Quizes</span>
											<h3 class="card-title mb-2 " id="totalquizes"></h3>
											<!--                          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>-->
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-12 col-6 mb-4">
									<div class="card">
										<div class="card-body">
											<div class="card-title d-flex align-items-start justify-content-between">
												<div class="avatar flex-shrink-0">
													<img
														src="<?= base_url('/assets/img/icons/unicons/wallet-info.png') ?>"
														alt="Credit Card"
														class="rounded"
													/>
												</div>
												<div class="dropdown">
													<button
														class="btn p-0"
														type="button"
														id="cardOpt6"
														data-bs-toggle="dropdown"
														aria-haspopup="true"
														aria-expanded="false"
													>
														<i class="bx bx-dots-vertical-rounded"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
														<a class="dropdown-item" href="javascript:void(0);">View More</a>
														<a class="dropdown-item" href="javascript:void(0);">Delete</a>
													</div>
												</div>
											</div>
											<span>Average Score</span>
											<h3 class="card-title text-nowrap mb-1" id="averageScore"></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Total Revenue -->
						<div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
							<div class="container" >
								<div class="card h-100">
									<div class="card-body">
										<div id=""><h5 class="text-nowrap mb-2" style="text-align: center">No of Quizez per day</h5> </div>

										<div id="userProgressChart"></div>

									</div>
								</div>
							</div>
						</div>
						<!--/ Total Revenue -->
						<div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
							<h3>Today</h3>
							<div class="row">
								<div class="col-6 mb-4">
									<div class="card">
										<div class="card-body">
											<div class="card-title d-flex align-items-start justify-content-between">
												<div class="avatar flex-shrink-0">
													<img src="<?= base_url('/assets/img/icons/unicons/paypal.png')?>" alt="Credit Card" class="rounded" />
												</div>
												<div class="dropdown">
													<button
														class="btn p-0"
														type="button"
														id="cardOpt4"
														data-bs-toggle="dropdown"
														aria-haspopup="true"
														aria-expanded="false"
													>
														<i class="bx bx-dots-vertical-rounded"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
														<a class="dropdown-item" href="javascript:void(0);">View More</a>
														<a class="dropdown-item" href="javascript:void(0);">Delete</a>
													</div>
												</div>
											</div>
											<span class="d-block mb-1">Total Quizes</span>
											<h3 class="card-title text-nowrap mb-2" id="totalToday1"></h3>
											<h3 class="card-title text-nowrap mb-2" id="totalToday"></h3>
											<small class="" id="iconClassTotal"> </small>
										</div>
									</div>
								</div>
								<div class="col-6 mb-4">
									<div class="card">
										<div class="card-body">
											<div class="card-title d-flex align-items-start justify-content-between">
												<div class="avatar flex-shrink-0">
													<img src="<?= base_url('/assets/img/icons/unicons/cc-primary.png')?>" alt="Credit Card" class="rounded" />
												</div>
												<div class="dropdown">
													<button
														class="btn p-0"
														type="button"
														id="cardOpt1"
														data-bs-toggle="dropdown"
														aria-haspopup="true"
														aria-expanded="false"
													>
														<i class="bx bx-dots-vertical-rounded"></i>
													</button>
													<div class="dropdown-menu" aria-labelledby="cardOpt1">
														<a class="dropdown-item" href="javascript:void(0);">View More</a>
														<a class="dropdown-item" href="javascript:void(0);">Delete</a>
													</div>
												</div>
											</div>
											<span class="fw-semibold d-block mb-1">Average Score</span>
											<h3 class="card-title mb-2" id="averagePercentageToday1"></h3>
											<h3 class="card-title mb-2" id="averagePercentageToday"></h3>
											<small class="" id="percentageArrow"></i></small>
										</div>
									</div>
								</div>
								<!-- </div>
				<div class="row"> -->
								<div class="col-12 mb-4">
									<h3>This Week Average Percentage</h3>
									<div class="card">
										<div class="card-body">
											<div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
												<div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
													<div class="card-title">
														<h5 class="text-nowrap mb-2">Profile Report</h5>
														<span class="badge bg-label-warning rounded-pill">This Week</span>
													</div>
													<div class="mt-sm-auto">
														<small class="text-success text-nowrap fw-semibold">
															<i class="fa fa-arrow-up"></i> Increase
														</small>
														<h3 class="mb-0" id="averagePercentage">0%</h3>
														<span id="percentageChange"></span>
													</div>
												</div>
												<div id="profileReportChart"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">

						<div id="historicalProgressChart"></div>


						<!-- Order Statistics -->
						<div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
							<div class="card h-100">
								<div class="card-header d-flex align-items-center justify-content-between pb-0">
									<div class="card-title mb-0">
										<h5 class="m-0 me-2">Quiz By category</h5>
									</div>

								</div>
								<div class="card-body" style="height: 300px">
									<canvas id="quizChartTotal"></canvas>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
							<div class="card h-100">
								<div class="card-header d-flex align-items-center justify-content-between pb-0">
									<div class="card-title mb-0">
										<h5 class="m-0 me-2">Score by category</h5>
									</div>

								</div>
								<div class="card-body">
									<div id="quizChartScore"></div>
								</div>
							</div>
						</div>

						<!--/ Transactions -->
					</div>
				</div>
				<!-- / Content -->

				<!-- Footer -->
				<footer class="content-footer footer bg-footer-theme">
					<div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
						<div class="mb-2 mb-md-0">
							©
							<script>
								document.write(new Date().getFullYear());
							</script>
							, made by
							<a href="https://  QuizBot.com" target="_blank" class="footer-link fw-bolder">  QuizBot</a>
						</div>

					</div>
				</footer>
				<!-- / Footer -->

				<div class="content-backdrop fade"></div>
			</div>
			<!-- Content wrapper -->
		</div>
		<!-- / Layout page -->
	</div>

	<!-- Overlay -->
	<div class="layout-overlay layout-menu-toggle"></div>
</div>


<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

</body>

<script>
	// Sample data

	// Fetch data from your API endpoint
function getUserProgress(){
	fetch('<?=base_url('index.php/welcome/get_user_progress')?>')
		.then(response => response.json())
		.then(data => {
			// Map fetched data to AmCharts format
			const chartData = data.map(record => ({
				date: new Date(record.createdDate),
				score: record.score
			}));

			// Create a chart instance
			// const chart = am4core.create("userProgressChart", am4charts.XYChart);

			// Add data
			// chart.data = chartData;
			historicalProgressData = [];
			historicalProgressData = chartData;
			const historicalDates = historicalProgressData.map(data => data.date);
			const formattedDates = historicalDates.map(date => {
				const options = { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' };
				return date.toLocaleDateString('en-US', options);
			});



			const historicalScores = historicalProgressData.map(data => data.score);

			const historicalProgressChartEl = document.getElementById('userProgressChart');
			const historicalProgressChartConfig = {
				series: [{ data: historicalScores }],
				chart: {
					height: 325,
					type: 'area'
				},
				dataLabels: {
					enabled: false
				},
				stroke: {
					width: 2,
					curve: 'smooth'
				},
				legend: {
					show: false
				},
				markers: {
					size: 6,
					colors: 'transparent',
					strokeColors: 'transparent',
					strokeWidth: 4,
					discrete: [
						{
							seriesIndex: 0,
							dataPointIndex: historicalScores.length - 1,
							size: 6,
							radius: 8
						}
					],
					hover: {
						size: 7
					}
				},
				colors: ['#3498db'], // Change color to your preference
				fill: {
					type: 'gradient',
					gradient: {
						shadeIntensity: 0.6,
						opacityFrom: 0.5,
						opacityTo: 0.25,
						stops: [0, 95, 100]
					}
				},
				xaxis: {
					categories: formattedDates,
					labels: {
						style: {
							fontSize: '13px',
							colors: '#777' // Change color to your preference
						}
					}
				},
				yaxis: {
					labels: {
						show: false
					},
					min: Math.min(...historicalScores),
					max: Math.max(...historicalScores),
					tickAmount: 4
				}
			};

			const historicalProgressChart = new ApexCharts(historicalProgressChartEl, historicalProgressChartConfig);
			historicalProgressChart.render();

		})
		.catch(error => {
			console.error('Error fetching data:', error);
		});

}


	function gettotalquizes(){

		$.ajax({
			url: '<?= base_url('index.php/welcome/getTotalQuiz')?>',
			type: 'POST',

			success: function (response) {



				var result = JSON.parse(response);


				$('#totalquizes').html(result.total);
				$('#averageScore').html(result.averagePercentage);
				$('#totalToday1').html(result.totalToday);
				$('#averagePercentageToday1').html(result.averagePercentageToday);

				const difference = result.averagePercentageToday - result.averagePercentageYesterday;
				const differenceTotal = result.totalToday - result.totalYesterday;

				const smallDifferenceElement = document.createElement('small');
				smallDifferenceElement.textContent = `(${Math.abs(difference).toFixed(2)}%)`;
				smallDifferenceElement.className = difference > 0 ? 'text-success small-text' : 'text-danger small-text';

				const smallDifferenceElementTotal = document.createElement('small');
				smallDifferenceElementTotal.textContent = `(${Math.abs(differenceTotal)})`;
				smallDifferenceElementTotal.className = differenceTotal > 0 ? 'text-success small-text' : 'text-danger small-text';

				const differenceContainer = document.createElement('div');
				differenceContainer.appendChild(smallDifferenceElement);

				const differenceContainerTotal = document.createElement('div');
				differenceContainerTotal.appendChild(smallDifferenceElementTotal);

// Clear existing content before appending the difference
				document.getElementById('averagePercentageToday').innerHTML = '';
				document.getElementById('totalToday').innerHTML = '';

				document.getElementById('averagePercentageToday').appendChild(differenceContainer);
				document.getElementById('totalToday').appendChild(differenceContainerTotal);

			},
			error: function (xhr, status, error) {
				// Handle error if needed
			}
		});





	}
	$(document).ready(function() {

		// Call the AJAX function here
		getweeklystats();
		fetchQuizDataCategory();
		fetchQuizDataCategoryScore();
		gettotalquizes();
		getUserProgress()

	});
	$('#studentDropdown').change(function() {

		var selectedUser = $(this).val();
		if (selectedUser == ''){
			selectedUser = 0;
		}

		$.ajax({
			url: '<?= base_url('index.php/welcome/updateSession'); ?>',
			method: 'POST',
			data: { user: selectedUser },
			success: function(response) {

				getweeklystats();
				fetchQuizDataCategory();
				fetchQuizDataCategoryScore();
				gettotalquizes();
				getUserProgress()
			},
			error: function(xhr, status, error) {
				console.error(error);
			}
		});
	});
	function getweeklystats(){

		// Fetch the weekly average percentages using AJAX
		$.ajax({
			url: '<?= base_url('index.php/welcome/getWeeklyAveragePercentages'); ?>',
			type: 'GET',
			success: function (response) {
				const responseData = JSON.parse(response);
				// response = JSON.parse(response)
				const dates = Object.keys(responseData);
				const avgPercentages = Object.values(responseData).map(value => parseFloat(value));
				// Calculate percentage change
				const currentPercentage = avgPercentages[avgPercentages.length - 1];
				const previousPercentage = avgPercentages[avgPercentages.length - 2];
				const percentageChange = ((currentPercentage - previousPercentage) / previousPercentage) * 100;

				// Update average percentage and percentage change on the page
				document.getElementById('averagePercentage').textContent = `${currentPercentage}%`;
				const percentageChangeSpan = document.getElementById('percentageChange');
				if (percentageChange > 0) {
					percentageChangeSpan.innerHTML = `<i class="fa fa-arrow-up text-success"></i> +${percentageChange.toFixed(2)}%`;
				} else if (percentageChange < 0) {
					percentageChangeSpan.innerHTML = `<i class="fa fa-arrow-down text-danger"></i> ${percentageChange.toFixed(2)}%`;
				} else {
					percentageChangeSpan.textContent = '';
				}

				// Initialize ApexCharts graph
				$("profileReportChart").html('');
				const profileReportChartEl = document.querySelector('#profileReportChart');

				let config = {
					colors: {
						primary: '#696cff',
						secondary: '#8592a3',
						success: '#71dd37',
						info: '#03c3ec',
						warning: '#ffab00',
						danger: '#ff3e1d',
						dark: '#233446',
						black: '#000',
						white: '#fff',
						body: '#f4f5fb',
						headingColor: '#566a7f',
						axisColor: '#a1acb8',
						borderColor: '#eceef1'
					}
				};
				const profileReportChartConfig = {
					chart: {
						height: 80,
						// width: 175,
						type: 'line',
						toolbar: {
							show: false
						},
						dropShadow: {
							enabled: true,
							top: 10,
							left: 5,
							blur: 3,
							color: config.colors.warning,
							opacity: 0.15
						},
						sparkline: {
							enabled: true
						}
						// Your other chart configuration settings...
					},
					grid: {
						show: false,
						padding: {
							right: 8
						}
					},
					colors: [config.colors.warning],
					dataLabels: {
						enabled: false
					},
					stroke: {
						width: 5,
						curve: 'smooth'
					},
					// Other ApexCharts configuration settings...
					series: [{
						name: 'Average Percentage',
						data: avgPercentages,
					}],
					xaxis: {
						categories: dates,
						// Other x-axis configuration...
					},
				};

				// Initialize and render the chart
				if (typeof profileReportChartEl !== undefined && profileReportChartEl !== null) {
					const profileReportChart = new ApexCharts(profileReportChartEl, profileReportChartConfig);
					profileReportChart.render();
				}

			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
			}
		});

	}

	function fetchQuizDataCategory() {
		$.ajax({
			url: "<?= base_url('index.php/welcome/fetchQuizDataCategory'); ?>",
			method: "GET",
			success: function(response) {
				const quizData = JSON.parse(response);

				createStackedGraph(quizData);
			},
			error: function(xhr, status, error) {
				console.error("Error fetching quiz data:", error);
			}
		});
	}
	function fetchQuizDataCategoryScore() {
		$.ajax({
			url: "<?= base_url('index.php/welcome/fetchQuizDataCategoryScore'); ?>",
			method: "GET",
			success: function(response) {
				const quizData = JSON.parse(response);

				createStackedGraphCategory(quizData);
			},
			error: function(xhr, status, error) {
				console.error("Error fetching quiz data:", error);
			}
		});
	}

	// Declare a variable to keep track of the Chart instance
	let quizChart;

	function createStackedGraph(quizData) {
		const categories = [...new Set(quizData.map(item => item.category))];
		const dates = [...new Set(quizData.map(item => item.createdDate))];

		const datasetByCategory = {};
		categories.forEach(category => {
			datasetByCategory[category] = [];
			dates.forEach(date => {
				const count = quizData.find(item => item.category === category && item.createdDate === date)?.count || 0;
				datasetByCategory[category].push(count);
			});
		});

		const ctx = document.getElementById("quizChartTotal").getContext("2d");

		// Destroy the existing chart instance if it exists
		if (quizChart) {
			quizChart.destroy();
		}

		// Clear the previous data and labels from the chart
		if (quizChart?.data) {
			quizChart.data.labels = [];
			quizChart.data.datasets = [];
		}

		quizChart = new Chart(ctx, {
			type: "bar",
			data: {
				labels: dates,
				datasets: categories.map(category => ({
					label: category,
					data: datasetByCategory[category],
					backgroundColor: getRandomColor(),
				})),
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					x: {
						stacked: true,
					},
					y: {
						stacked: true,
						beginAtZero: true,
					},
				},
			},
		});
	}


	function createStackedGraphCategory(averageScoresData) {
		const categories = [...new Set(averageScoresData.map(item => item.category))];
		const dates = [...new Set(averageScoresData.map(item => item.createdDate))];

		const series = categories.map(category => ({
			name: category,
			data: dates.map(date => {
				const dataItem = averageScoresData.find(item => item.category === category && item.createdDate === date);
				return dataItem ? parseFloat(dataItem.average_score) : 0;
			})
		}));

		const stackedGraphConfig = {
			chart: {
				type: 'bar',
				height: 350,
				stacked: true
			},
			plotOptions: {
				bar: {
					horizontal: false
				},
			},
			dataLabels: {
				enabled: false
			},
			xaxis: {
				categories: dates,
			},
			legend: {
				position: 'top',
			},
			fill: {
				opacity: 1
			},
			series: series
		};

		const stackedGraphEl = document.querySelector('#quizChartScore');
		if (stackedGraphEl) {
			const stackedGraph = new ApexCharts(stackedGraphEl, stackedGraphConfig);
			stackedGraph.render();
		}
	}


	function getRandomColor() {
		return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`;
	}



</script>

</html>







</html>
