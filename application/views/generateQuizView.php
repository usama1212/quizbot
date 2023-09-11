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
		#saveChanges {
			display: none;
		}
		#loadingSpinner {
			display: none;
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
					<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Generate Quiz</span></h4>

					<div class="row">
						<div class="col-md-12">

							<div class="card mb-12">
								<h5 class="card-header">Custom Question Generation</h5>
								<!-- Account -->
								<div class="card-body">

									<div class="container mt-5">
										<div class="row justify-content-center">
											<div class="col-md-8">
												<form id="textForm" class="border p-4">
													<div class="mb-3">
														<label for="text" class="form-label">Enter Text</label>
														<textarea class="form-control" name="text" id="text" rows="6" placeholder="Enter text here..." required></textarea>
													</div>
													<div class="d-grid">
														<button type="submit" class="btn btn-primary">Generate Questions</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<div id="loadingSpinner" class="text-center mt-3">
										<img src="<?=base_url('/assets/img/avatars/loadingImg.gif') ?>" alt="Loading..." />


									</div>


									<div id="questions"></div>

								</div>


									<div id="quizContainer">
										<!-- Questions and choices will be dynamically added here -->
									</div>
									<div class="card-body text-center">

										<button id="saveChanges" class="btn btn-primary">Save Changes</button>
									</div>




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
						<div>
							<a href="https://  QuizBot.com/license/" class="footer-link me-4" target="_blank">License</a>
							<a href="https://  QuizBot.com/" target="_blank" class="footer-link me-4">More Themes</a>

							<a
								href="https://  QuizBot.com/demo/  QuizBot-bootstrap-html-admin-template/documentation/"
								target="_blank"
								class="footer-link me-4"
							>Documentation</a
							>

							<a
								href="https://github.com/  QuizBot/  QuizBot-html-admin-template-free/issues"
								target="_blank"
								class="footer-link me-4"
							>Support</a
							>
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
	$(document).ready(function () {
		$("#textForm").submit(function (event) {
			event.preventDefault();
			showLoadingSpinner();
			generateQuestions();
		});
	});
	function showLoadingSpinner() {
		$("#loadingSpinner").show();
	}

	function hideLoadingSpinner() {
		$("#loadingSpinner").hide();
	}
	function generateQuestions() {
		var text = $("#text").val();
	function showSaveChangesButton() {
			$("#saveChanges").show();
		}

		$.ajax({
			url: "http://127.0.0.1:5000/summarize",
			method: "POST",
			data: { text: text },
			success: function (response) {
				// displayQuestions(response);
				quizData = response;
				hideLoadingSpinner();
				showSaveChangesButton();
				// Assuming your JSON data is named `quizData`
				const quizContainer = document.getElementById("quizContainer");
				const saveChangesButton = document.getElementById("saveChanges");

				function createQuestionBlock(question) {
					const questionBlock = document.createElement("div");
					questionBlock.className = "question-block card mb-3";
					questionBlock.innerHTML = `
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
      <h5 class="mb-0">Question ${question.index}</h5>
      <button class="btn btn-danger btn-sm remove-question-btn">Remove</button>
    </div>
    <div class="card-body">
      <textarea class="form-control question-text mb-3" rows="3">${question.output}</textarea>
      <form class="choices-form">
        ${question.options
						.map(
							(option, index) =>
								`<div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" name="question-${question.index}" value="${option.choice}" ${
									option.choice === question.correct_answer ? "checked" : ""
								}>
                    </div>
                  </div>
                  <input type="text" class="form-control choice-text" value="${option.choice}">
                </div>
              </div>`
						)
						.join("")}

      </form>
    </div>
  </div>
`;


					// Attach event listener to the Remove button
					const removeQuestionBtn = questionBlock.querySelector(".remove-question-btn");
					removeQuestionBtn.addEventListener("click", () => {
						questionBlock.remove();
					});

					return questionBlock;
				}



// Populate the quizContainer with question blocks
				quizData.forEach(question => {
					const questionBlock = createQuestionBlock(question);
					quizContainer.appendChild(questionBlock);
				});
				saveChangesButton.addEventListener("click", saveChanges);

				function saveChanges() {
					const updatedQuizData = [];

					// Iterate through question blocks and collect updated data
					const questionBlocks = document.querySelectorAll(".question-block");
					questionBlocks.forEach((block, index) => {
						const questionText = block.querySelector(".question-text").value;
						const choicesForm = block.querySelector(".choices-form");
						const choices = Array.from(choicesForm.querySelectorAll(".choice-text")).map(choice => choice.value);
						const correctAnswer = choicesForm.querySelector("input[name^='question']:checked").value;

						updatedQuizData.push({
							output: questionText,
							options: choices.map((choice, i) => ({ choice: choice, letter: String.fromCharCode(97 + i) })),
							correct_answer: correctAnswer,
							index: index + 1
						});
					});

					console.log(updatedQuizData);


					$.ajax({
						url: "<?= base_url('index.php/welcome/save_quiz_data')?>", // Update the URL to match your controller's method
						type: "POST",
						data: JSON.stringify(updatedQuizData),
						contentType: "application/json",
						success: function(response) {
							console.log("Quiz data saved successfully:", response);
						},
						error: function(error) {
							console.error("Error saving quiz data:");
						}
					});
				 }

// Add event listener to update correct answer when option value changes
				document.addEventListener("change", function(event) {
					if (event.target.classList.contains("choice-text")) {
						const choicesForm = event.target.closest(".choices-form");
						const correctAnswerInput = choicesForm.querySelector("input[name^='question']:checked");
						correctAnswerInput.value = event.target.value;
					}
				});


			}
		});
	}


</script>



</html>
