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

		body {
			background-color: #eee;
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
					<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Attempt quiz
						/ <?= $category ?></h4>

					<div class="row">
						<div class="col-md-12">

							<div class="card mb-4">

								<!-- Account -->
								<div class="card-body">
									<div class="container ">
										<div class="d-flex justify-content-center row">
											<div class="container chat-container">

												<div id="chat-container">
													<!-- Chat messages will be displayed here -->
												</div>
												<input type="text" id="user-input" class="user-input"
													   placeholder="Type your answer here">
												<button id="send-btn" class="btn btn-primary mt-2">Send</button>
												<!--												<button id="reattempt-btn" >Reattempt Quiz</button>-->
												<!--												<a href="-->
												<?php //= base_url(); ?><!--"  id="return-dashboard-btn">Return to Dashboard</a>-->

											</div>
										</div>
									</div>
								</div>
							</div>

							<hr class="my-0"/>

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
						<a href="https://  QuizBot.com" target="_blank" class="footer-link fw-bolder"> QuizBot</a>
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
		uploadFile();
		quizData = [];

		function uploadFile() {
			var category = '<?= $category ?>';
			$.ajax({
				url: '<?= base_url("index.php/welcome/getCategoryQuiz"); ?>',
				type: 'POST',
				data: { category: category }, // Send the selected category
				success: function (data) {
					quizData = JSON.parse(data);
					displayMessage('How many questions would you like to answer?', 'bot');

				},
				error: function (xhr, status, error) {
					$.notify('Error uploading image: ' + xhr.responseText, "error");
				}
			});
		}
	});

	let shuffledQuestions = [];
	let currentQuestionIndex = -1; // Start with -1 to handle the initial question
	let numQuestions = 0;
	let startTime;
	let score = 0;
	var incorrectAnswers = [];

	function shuffleArray(array) {
		const shuffled = array.slice();
		for (let i = shuffled.length - 1; i > 0; i--) {
			const j = Math.floor(Math.random() * (i + 1));
			[shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
		}
		return shuffled;
	}

	function displayMessage(message, sender) {
		const chatContainer = document.getElementById('chat-container');
		const messageDiv = document.createElement('div');
		messageDiv.classList.add('message', sender);
		messageDiv.textContent = message;
		chatContainer.appendChild(messageDiv);
	}

	function showSuggestionsAndWebsites(questionIndex) {
		// Hit the API to get suggestions and relevant websites for the specified question
		const requestData = {
			incorrect_answers: [
				{
					question: shuffledQuestions[questionIndex].question,
					user_answer: incorrectAnswers[questionIndex]
				}
			],
			topics: ["<?= $category ?>"]
		};

		$.ajax({
			url: '<?= base_url('index.php/welcome/getSuggestionOfWebsites') ?>',
			type: 'POST',
			data: {
				jsonData: requestData,
			},
			success: function (response) {
				response = JSON.parse(response);
				const question = shuffledQuestions[questionIndex];
				if (question.video_link) {
					displayMessage('Assigned Video Link:', 'bot');
					const videoLink = document.createElement('a');
					videoLink.href = question.video_link;
					videoLink.target = '_blank';
					videoLink.textContent = question.video_link;
					document.getElementById('chat-container').appendChild(videoLink);
				}
				if (response.suggestions) {
					displayMessage('Suggestions:', 'bot');
					displayMessage(response.suggestions, 'bot-suggestions');
				}
				if (response.relevant_data && response.relevant_data.length > 0) {
					displayMessage('Watch Videos to learn:', 'bot');
					const youtubeList = document.createElement('ul');

					response.relevant_data[0].youtube_links.forEach((youtubeLink) => {
						const listItem = document.createElement('li');
						const link = document.createElement('a');
						link.href = youtubeLink;
						link.target = '_blank';
						link.textContent = youtubeLink;
						listItem.appendChild(link);
						youtubeList.appendChild(listItem);
					});
					document.getElementById('chat-container').appendChild(youtubeList);

				}

				if (response.relevant_websites && response.relevant_websites.length > 0) {
					displayMessage('Relevant Websites:', 'bot');
					const websitesList = document.createElement('ul');
					response.relevant_websites[0].websites.forEach((website) => {
						const listItem = document.createElement('li');
						const link = document.createElement('a');
						link.href = website;
						link.target = '_blank';
						link.textContent = website;
						listItem.appendChild(link);
						websitesList.appendChild(listItem);
					});
					document.getElementById('chat-container').appendChild(websitesList);
				}


				// Load the next question after displaying suggestions and websites
				loadNextQuestion();
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
			}
		});
	}

	function loadNextQuestion() {
		currentQuestionIndex++;
console.log("here")
		if (currentQuestionIndex < numQuestions) {
			const question = shuffledQuestions[currentQuestionIndex];
			startTime = new Date(); // Start timer for this question
			displayMessage(question.question, 'bot');
			question.choices.forEach((choice, index) => {
				displayMessage(`${String.fromCharCode(97 + index)}. ${choice}`, 'bot-choices');
			});
		} else {
			const endTime = new Date();
			const timeElapsed = (endTime - startTime) / 1000; // Time elapsed in seconds
			const percentage = (score / numQuestions) * 100;
			displayMessage('Quiz Complete!', 'bot');
			displayMessage(`Total Score: ${score}`, 'bot');
			displayMessage(`Percentage: ${percentage.toFixed(2)}%`, 'bot');
			displayMessage(`Time Consumed: ${timeElapsed.toFixed(2)} seconds`, 'bot');

			const quizData = {
				timeConsumed: timeElapsed,
				userID: <?= $_SESSION['userID'] ?>,
				category: '<?= $category ?>',
				totalQuestions: numQuestions,
				score: score,
				percentage: percentage,
				// Other statistics
			};

			$.ajax({
				url: '<?= base_url('index.php/welcome/save_statistics') ?>',
				type: 'POST',
				data: { quiz_data: quizData },
				success: function (response) {
					// Handle success if needed

				},
				error: function (xhr, status, error) {
					// Handle error if needed
				}
			});
			$('#send-btn').hide();
			$('#user-input').hide();
		}
	}

	function loadQuestion() {
		console.log(currentQuestionIndex)
		console.log("her")
		if (currentQuestionIndex === -1) {
			// Ask the user how many questions they want to answer
			displayMessage('How many questions would you like to answer?', 'bot');
		}
	}

	$('#send-btn').click(() => {
		const userAnswer = $('#user-input').val().toLowerCase().trim();
		$('#user-input').val("");
		if (currentQuestionIndex === -1) {
			numQuestions = parseInt(userAnswer);
			shuffledQuestions = shuffleArray(quizData.questions);
			displayMessage(`Great! Let's start the quiz with ${numQuestions} questions.`, 'bot');
			loadNextQuestion(); // Load the first question
		} else if (currentQuestionIndex < numQuestions) {
			const correctAnswerIndex = shuffledQuestions[currentQuestionIndex].choices.findIndex(
				(choice) =>
					choice.toLowerCase() === shuffledQuestions[currentQuestionIndex].answer.toLowerCase()
			);
			const userAnswerIndex = userAnswer.charCodeAt(0) - 97;
			displayMessage(`You: ${userAnswer}`, 'user');
			if (userAnswerIndex === correctAnswerIndex) {
				displayMessage('Correct!', 'bot-correct');
				score++;
			} else {
				displayMessage(
					`Wrong. Correct answer: ${String.fromCharCode(97 + correctAnswerIndex)}`,
					'bot-wrong'
				);
				incorrectAnswers.push(userAnswer);

				// Show suggestions and relevant websites for the current question
				showSuggestionsAndWebsites(currentQuestionIndex);

				// Return and don't load the next question until suggestions and websites are displayed
				return;
			}
			loadNextQuestion();
		}
	});
</script>





<style>
	.chat-container {
		max-width: 400px;
		margin: 0 auto;
		border: 1px solid #ccc;
		border-radius: 10px;
		padding: 10px;
		background-color: #f8f9fa;
		box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
	}

	.message {
		padding: 5px;
		margin: 5px;
		border: 1px solid #ccc;
		background-color: #f9f9f9;
		border-radius: 5px;
	}

	.user {
		text-align: right;
		background-color: #c5e5ff;
	}

	.user-message {
		background-color: #e2e3e5;
		text-align: right;
	}

	.bot-message {
		background-color: #d1e8f1;
		text-align: left;
	}

	.bot-message-choices {
		background-color: #d1e8f1;
		text-align: left;
		font-style: italic;
	}

	.user-input {
		width: 100%;
		margin-top: 10px;
		border: none;
		border-radius: 5px;
		padding: 8px;
		box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
	}

	.bot {
		text-align: left;
		background-color: #ffecd0;
	}

	.bot-choices {
		text-align: left;
		background-color: #fff;
		font-style: italic;
	}

	.bot-correct {
		text-align: left;
		background-color: #d0ffd0;
	}

	.bot-wrong {
		text-align: left;
		background-color: #ffd0d0;
	}
</style>

</html>
