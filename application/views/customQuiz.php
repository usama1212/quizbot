
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
	<!-- Add these lines to the <head> section of your HTML -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

	<!-- Add these lines to the <head> section of your HTML -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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
					<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Custom Quizes List </h4>

					<div class="row">
						<div class="col-md-12">

							<div class="card mb-4">

								<!-- Account -->
								<div class="card-body">
									<div class="container ">
										<div class="d-flex justify-content-center row">

											<div class="container-xxl flex-grow-1 container-p-y">
												<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="<?= base_url('index.php/welcome/generateQuizView') ?>" class="btn btn-primary float-end">Add New</a></span></h4>

												<!-- Basic Bootstrap Table -->
												<div class="card" style="margin-top: 58px;">

													<div class="table-responsive text-nowrap">
														<table class="table table-hover" id="students_table">
															<thead>
															<tr>
																<th>ID</th>
																<th>Status</th>
																<th>Created Date</th>

																<th>Actions</th>
															</tr>
															</thead>
															<tbody class="table-border-bottom-0">


															<?php foreach ($quiz as $quiz):

																?>




																<tr>
																	<td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $quiz->id?></strong></td>

																	<td>
																		<?= $quiz->status = 1 ? 'Active' : 'In Active' ?>
																	</td>
																	<td>
																		<input type="hidden" id="quizId" value="<?= $quiz->id ?>">
																		<input type="hidden" id="quizData" value='<?= json_encode($quiz->data) ?>'>

																		<?= $quiz->created_at?>
																	</td>
																	<td>
																		<div class="dropdown">
																			<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
																				<i class="bx bx-dots-vertical-rounded"></i>
																			</button>
																			<div class="dropdown-menu">

																					<a  class="dropdown-item edit-button" data-bs-toggle="modal" data-bs-target="#editModal" ><i class="bx bx-trash me-1"></i>Edit</a>


																				<a class="dropdown-item" href="javascript:void(0);"
																				><i class="bx bx-trash me-1"></i> Delete</a
																				>
																			</div>
																		</div>
																	</td>
																</tr>

															<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>

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

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editModalLabel">Edit Quiz Data</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="questions-container"></div>
				<!-- Form or content to display quiz data goes here -->
				<!-- You can use PHP to populate the form fields with the data -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<!-- Add a button for saving changes if needed -->
			</div>
		</div>
	</div>
</div>


<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>

<script>

	$(document).ready(function() {
		$('#students_table').DataTable();


		$('.edit-button').click(function () {
			// Retrieve data from hidden input fields
			const quizId = $('#quizId').val();
			const quizDataJson = $('#quizData').val();

			try {
				// Parse quizDataJson into an array of objects
				const quizData1 = JSON.parse(quizDataJson);
				const quizData = JSON.parse(quizData1);

				if (Array.isArray(quizData)) {
					quizData.forEach(question => {
						const questionBlock = document.createElement("div");
						questionBlock.className = "question-block card mb-3";
						questionBlock.innerHTML = `
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">Question ${question.index}</h5>
<!--                    <button class="btn btn-danger btn-sm remove-question-btn">Remove</button>-->
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

						// Append the question block to a container element in your HTML
						const container = document.getElementById("questions-container");
						container.appendChild(questionBlock);
					});

					// Show the modal
					$('#editModal').modal('show');
				} else {
					console.error('quizData is not an array:', quizData);
				}
			} catch (error) {
				// Handle JSON parsing errors here
				console.error('Error parsing JSON:', error);
			}
		});


	});




</script>


</body>


</html>
