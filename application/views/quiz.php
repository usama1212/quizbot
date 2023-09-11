
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
	<style>

		body{
			background-color:#eee;
		}

		label.radio {
			cursor: pointer;
		}

		label.radio input {
			position: absolute;
			top: 0;
			left: 0;
			visibility: hidden;
			pointer-events: none;
		}

		label.radio span {
			padding: 4px 0px;
			border: 1px solid red;
			display: inline-block;
			color: red;
			width: 100px;
			text-align: center;
			border-radius: 3px;
			margin-top: 7px;
			text-transform: uppercase;
		}

		label.radio input:checked + span {
			border-color: red;
			background-color: red;
			color: #fff;
		}

		.ans {
			margin-left: 36px !important;
		}

		.btn:focus {
			outline: 0 !important;
			box-shadow: none !important;
		}

		.btn:active {
			outline: 0 !important;
			box-shadow: none !important;
		}


		.custom-file-label::after {
			content: "Browse"; /* Change the text of the "Choose File" button */
		}

		/* Optional: Increase the width of the "Choose File" button */
		.custom-file-label::before {
			content: ""; /* Empty content to show only the styled button */
			display: inline-block;
			width: 80px; /* Adjust the width as needed */
			text-align: center;
		}

		/* Optional: Style the custom file input button */
		.custom-file-input {
			cursor: pointer; /* Show pointer cursor on hover */
		}

	</style>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
	<div class="layout-container">
		<!-- Menu -->

		<!-- Layout container -->
		<div class="layout-page">


			<!-- Content wrapper -->
			<div class="content-wrapper">
				<!-- Content -->

				<div class="container-xxl flex-grow-1 container-p-y">
					<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Attempt quiz</h4>

					<div class="row">
						<div class="col-md-12">

							<div class="card mb-4">

								<!-- Account -->
								<div class="card-body">
									<div class="container ">
										<div class="d-flex justify-content-center row">
											<div class="">

													<div id="questionsDiv">

													</div>
													<div id="quiz-container">
														<div class="container mt-5">
															<div class="card">
																<div class="card-header">
																	<h1 class="text-center">SQL Quiz</h1>
																</div>
																<div class="card-body">
																	<div id="question" class="mb-3"></div>
																	<div id="choices"></div>
																</div>
																<div class="card-footer">
																	<button id="next-btn" class="btn btn-primary">Next</button>
																	<div id="score" class="mt-3 text-center" style="display: none;"></div>
																</div>
															</div>
														</div>													</div>

												</div>
											</div>
										</div>
									</div>
								</div>

								<hr class="my-0" />

								<!-- /Account -->
							</div>

						</div>
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




</body>

<script>
	$( document ).ready(function() {
		uploadFile();
		quizData =[];
		function uploadFile() {


			$.ajax({
				url: '<?= base_url("index.php/welcome/readJson1"); ?>',
				type: 'POST',
				processData: false,
				contentType: false,
				success: function (data) {
					quizData = JSON.parse(data)

					loadQuestion();

				},
				error: function (xhr, status, error) {
					$.notify('Error uploading image: ' + xhr.responseText, "error");
				}
			});
		}

	});

	let currentQuestion = 0;
	let score = 0;

	function loadQuestion() {
		if (currentQuestion < quizData.questions.length) {
			const question = quizData.questions[currentQuestion];
			$("#question").text(question.question);
			$("#choices").empty();
			question.choices.forEach((choice, index) => {
				$("#choices").append(`<label><input type="radio" name="choice" value="${choice}"> ${choice}</label><br>`);
			});
		} else {
			showScore();
		}
	}

	function showScore() {
		$("#question").text("Quiz Complete");
		$("#choices").empty();
		$("#next-btn").hide();
		$("#score").show().text(`Your score: ${score} out of ${quizData.questions.length}`);
	}

	$("#next-btn").click(() => {
		const selectedChoice = $("input[name='choice']:checked").val();
		if (selectedChoice !== undefined) {
			const correctAnswer = quizData.questions[currentQuestion].answer;
			if (selectedChoice === correctAnswer) {
				score++;
			}
			currentQuestion++;
			loadQuestion();
		}
	});



</script>



</html>
