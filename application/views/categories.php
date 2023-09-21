
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
					<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Quiz Categories </h4>

					<div class="row">
						<div class="col-md-12">

							<div class="card mb-4">

								<!-- Account -->
								<div class="card-body">
									<div class="container ">
										<div class="d-flex justify-content-center row">

											<div class="container-xxl flex-grow-1 container-p-y">
												<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><button  id="addNewCategorybtn" onclick="openModelAddCategory();" class="btn btn-primary float-end">Add New</button></span></h4>

												<!-- Basic Bootstrap Table -->
												<div class="card" style="margin-top: 58px;">

													<div >
														<table class="stripe" id="students_table">
															<thead>
															<tr>
																<th>ID</th>
																<th>Name</th>
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
																		<?= $quiz->name ?>
																	</td>

																	<td>
																		<input type="hidden" id="quizId" value="<?= $quiz->id ?>">

																		<?= $quiz->createdDate?>
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
<div class="modal fade" id="addNewCategory" tabindex="-1" aria-labelledby="addNewCategory" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editModalLabel">Add Category</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<label for="quizCategory" class="form-label">Quiz Category</label>
					<input type="text" class="form-control" id="quizCategory" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="saveCategory();" id="saveChanges">Save</button>
			</div>
		</div>
	</div>
</div>


<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>




</body>
<script>
	$(document).ready(function () {
		$('#students_table').DataTable();


	});

	function openModelAddCategory() {
		$('#addNewCategory').modal('toggle');


	}
	function saveCategory(){

		var category = $("#quizCategory").val();
		if (category == ''){
			$.notify('Enter a name' , "error");
				return;
		}
		$.ajax({
			url: '<?= base_url("index.php/welcome/saveCategory"); ?>',
			type: 'POST',
			data: { category: category }, // Send the selected category
			success: function (data) {
if (data == 1){

	$.notify('Category saved!' , "success");
	$('#addNewCategory').modal('toggle');
}

			},
			error: function (xhr, status, error) {
				$.notify('Error' , "error");
			}
		});


	}



</script>

</html>
