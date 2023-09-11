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
					<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

					<div class="row">
						<div class="col-md-12">

							<div class="card mb-4">
								<h5 class="card-header">Profile Details</h5>
								<!-- Account -->
								<div class="card-body">
									<div class="d-flex align-items-start align-items-sm-center gap-4">
										<img
											src="<?=$imgURL ?>"
											alt="user-avatar"
											class="d-block rounded"
											height="100"
											width="100"
											id="uploadedAvatar"
										/>
										<div class="button-wrapper">
											<form id="uploadForm" enctype="multipart/form-data">
<!--											<label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">-->
												<span class="d-none d-sm-block">Upload new photo</span>
												<i class="bx bx-upload d-block d-sm-none"></i>
												<input type="file" class="custom-file-input" name="userfile" id="userfile">

												<input type="hidden" name="uploaded_image" id="uploaded_image">
												<input type="button" class="btn btn-danger" value="Upload" onclick="uploadFile()">

<!--											</label>-->
<!--												<input type="submit" value="Upload" />-->
											</form>

											<p class="text-muted mb-0">Allowed JPG, JPEG or PNG. Max size of 800K</p>
										</div>
									</div>
								</div>

								<hr class="my-0" />
								<div class="card-body">
									<form id="formAccountSettings" method="POST" onsubmit="return false">
										<div class="row">
											<div class="mb-3 col-md-6">
												<label for="firstName" class="form-label">First Name</label>
												<input
													class="form-control"
													type="text"
													id="firstName"
													name="firstName"
													value="<?= $firstName?>"
													autofocus
												/>
											</div>
											<div class="mb-3 col-md-6">
												<label for="lastName" class="form-label">Last Name</label>
												<input class="form-control" type="text" name="lastName" id="lastName" value="<?= $lastName?>" />
											</div>
											<div class="mb-3 col-md-6">
												<label for="email" class="form-label">E-mail</label>
												<input
													class="form-control"
													type="text"
													id="email"
													name="email"
													disabled
													value="<?= $email?>"
													placeholder="john.doe@example.com"
												/>
											</div>

											<div class="mb-3 col-md-6">
												<label class="form-label" for="phoneNumber">Phone Number</label>
												<div class="input-group input-group-merge">
													<span class="input-group-text"></span>
													<input
														type="text"
														id="phoneNumber"
														name="phoneNumber"
														class="form-control"
														value="<?= $phoneNumber?>"
														placeholder="+44202 555 0111"
													/>
												</div>
											</div>
											<div class="mb-3 col-md-6">
												<label for="address" class="form-label">Address</label>
												<input type="text" class="form-control" value="<?=$address?>" id="address" name="address" placeholder="Address" />
											</div>

											<div class="mb-3 col-md-6">
												<label class="form-label" for="country">Country</label>
												<select id="country" class="select2 form-select">
													<option value="">Select</option>
													<option value="Australia">Australia</option>
													<option value="Bangladesh">Bangladesh</option>
													<option value="Belarus">Belarus</option>
													<option value="Brazil">Brazil</option>
													<option value="Canada">Canada</option>
													<option value="China">China</option>
													<option value="France">France</option>
													<option value="Germany">Germany</option>
													<option value="India">India</option>
													<option value="Indonesia">Indonesia</option>
													<option value="Israel">Israel</option>
													<option value="Italy">Italy</option>
													<option value="Japan">Japan</option>
													<option value="Korea">Korea, Republic of</option>
													<option value="Mexico">Mexico</option>
													<option value="Philippines">Philippines</option>
													<option value="Russia">Russian Federation</option>
													<option value="South Africa">South Africa</option>
													<option value="Thailand">Thailand</option>
													<option value="Turkey">Turkey</option>
													<option value="Ukraine">Ukraine</option>
													<option value="United Arab Emirates">United Arab Emirates</option>
													<option value="United Kingdom">United Kingdom</option>
													<option value="United States">United States</option>
												</select>
											</div>


										</div>
										<div class="mt-2">
											<button type="submit" class="btn btn-primary me-2" onclick="saveProfile()" >Save changes</button>
											<a type="reset" href="<?= base_url()?>" class="btn btn-outline-secondary">Cancel</a>
										</div>
									</form>
								</div>
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



		function uploadFile() {
			var formData = new FormData($('#uploadForm')[0]);

			$.ajax({
				url: '<?= base_url("index.php/welcome/upload_file"); ?>',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {

					$.notify('Image uploaded successfully!', "success");
					console.log(data)
				},
				error: function (xhr, status, error) {
					$.notify('Error uploading image: ' + xhr.responseText, "error");
				}
			});
		}

		$('#country').val('<?= $country?$country : '' ?>')

		function saveProfile(){
			var name = $('#firstName').val();
			var lastName = $('#lastName').val();
			var email = $('#email').val();
			var phoneNumber = $('#phoneNumber').val();
			var address = $('#address').val();
			var country = $('#country').val();


			$.ajax({
				url: '<?= base_url('index.php/welcome/saveProfile')?>',
				method: 'POST',
				data: {
					name: name,
					lastName: lastName,
					email:email,
					phoneNumber:phoneNumber,
					address:address,
					country:country,

				},
				success: function (response) {
					if (response == 1){
						$.notify("settings saved successfully!", "success");

						window.location.href = "<?= base_url('index.php/welcome/userProfile')?>";
					}else{
						$.notify("something went wrong", "error");

					}

				},
				error: function (xhr, status, error) {
					console.error(error);
				}
			});


		}


</script>

</html>
