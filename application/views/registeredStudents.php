
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
					<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Registered Students </h4>

					<div class="row">
						<div class="col-md-12">

							<div class="card mb-4">

								<!-- Account -->
								<div class="card-body">
									<div class="container ">
										<div class="d-flex justify-content-center row">

											<div class="container-xxl flex-grow-1 container-p-y">
												<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><input type="button" class="btn btn-primary float-end" name="Add New" id="addStudentBtn" value="Add New" data-bs-toggle="modal" data-bs-target="#addStudentModal"></span> </h4>

												<!-- Basic Bootstrap Table -->
												<div class="card" style="margin-top: 58px;">

													<div class="table-responsive text-nowrap">
														<table class="table table-hover" id="students_table">
															<thead>
															<tr>
																<th>Name</th>
																<th>Last Name</th>
																<th>Email</th>

																<th>Actions</th>
															</tr>
															</thead>
															<tbody class="table-border-bottom-0">


															<?php foreach ($students as $student): ?>
															<tr>
																<td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $student->name?></strong></td>

																<td>
																	<?= $student->lastName?>
																</td>
																<td>
																	<?= $student->email?>
																</td>
																<td>
																	<div class="dropdown">
																		<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
																			<i class="bx bx-dots-vertical-rounded"></i>
																		</button>
																		<div class="dropdown-menu">
																			<a class="dropdown-item" href="javascript:void(0);"
																			><i class="bx bx-edit-alt me-1"></i> Edit</a
																			>
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
			<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addStudentModalLabel">Add Students</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<!-- Inside the modal body -->
						<div class="modal-body">
							<form id="addStudentForm">
								<div class="mb-3">
									<label for="selectedStudents" class="form-label">Select Students</label>
									<select id="studentDropdown" class="form-control" ></select>
								</div>
							</form>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="addStudentsBtn">Add Students</button>
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

<script>

	$(document).ready(function() {
		$('#students_table').DataTable();

		$('#addStudentBtn').click(function() {
			// Open the modal and fetch students
			fetchStudents();
		});

		$('#addStudentsBtn').click(function() {
			// Handle adding students when the "Add Students" button is clicked
			addSelectedStudents();
		});
	});
	function fetchStudents() {
		$.ajax({
			url: '<?= base_url('index.php/welcome/getNewStudents')?>', // Replace with the actual endpoint
			method: 'POST',
			success: function (data) {
				data = JSON.parse(data);

// Populate the multi-select dropdown with fetched students
				var $dropdown = $('#studentDropdown');

				$dropdown.empty();

				$.each(data, function(index, student) {
					$dropdown.append($('<option>', {
						value: student.id,
						text: student.name + ' (' + student.email + ')'
					}));
				});


				$('#addStudentModal').modal('show');

			},
			error: function() {
				alert('Error fetching students');
			}
		});
	}

	function addSelectedStudents() {
		var selectedStudents = $('#studentDropdown').val();
		if (selectedStudents && selectedStudents.length > 0) {
			$.ajax({
				url: '<?=base_url('index.php/welcome/addStudent')?>', // Adjust the URL to your actual endpoint
				type: 'POST',
				data: { selectedStudents: selectedStudents },
				dataType: 'json',
				success: function(data) {
					$('#addStudentModal').modal('toggle');
				},
				error: function() {
					alert('Error adding students');
				}
			});
		} else {
			alert('Please select at least one student');
		}
	}




</script>


</body>


</html>
