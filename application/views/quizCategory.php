
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
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f5f5f5;
		}

		.container {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}

		h1 {
			font-size: 2.5rem;
			margin-bottom: 20px;
		}

		form {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		label {
			font-size: 1.2rem;
			margin-bottom: 10px;
		}

		select, button {
			padding: 10px;
			font-size: 1rem;
			border: none;
			border-radius: 5px;
			margin-bottom: 15px;
			outline: none;
		}

		button {
			background-color: #007bff;
			color: white;
			cursor: pointer;
			transition: background-color 0.2s;
		}

		button:hover {
			background-color: #0056b3;
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

				<div class="container">
					<h1>Select a Quiz Category</h1>
					<form id="category-form">
						<label for="category-select">Choose a Category:</label>
						<select id="category-select">
							<option value="SQL">SQL</option>
							<option value="Python">Python</option>
							<!-- Add more categories as needed -->
						</select>
						<button type="submit">Start Quiz</button>
					</form>
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



<script>
	document.getElementById('category-form').addEventListener('submit', function(event) {
		event.preventDefault();

		const selectedCategory = document.getElementById('category-select').value;

		// Add a class to trigger an animation
		document.querySelector('.container').classList.add('fadeOut');
		setTimeout(() => {
			// Redirect after animation
			window.location.href = `<?= base_url('index.php/welcome/quizView')?>?category=${selectedCategory}`;
		}, 500);

	});

</script>

</body>




</html>
