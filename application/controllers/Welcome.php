<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('pdf_processing');
	}

	public function index()
	{

		if (isset($_SESSION['name'])) {

			$this->load->view('sidebar.php');

			if ($_SESSION['userType'] == 'Teacher') {
				$sql = 'select * from student_teacher st, user u where st.studentID = u.id And st.teacherID = ' . $_SESSION['userID'];

				$result = $this->db->query($sql)->result();
				$data['result'] = $result;

				$this->load->view('teacherIndex.php', $data);

			} else {
				$this->load->view('index1.php');

			}
			$this->load->view('template.php');

		} else {
			$this->load->view('template.php');
			$this->load->view('login.php');

		}


	}

	public function login()
	{

		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));
		$sql = "select * from user where (email ='" . $email . "' OR name = '" . $email . "') and password = '" . $password . "'";

		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {

			$result = $result->row();
			$_SESSION['name'] = $result->name;
			$_SESSION['userID'] = $result->id;
			$_SESSION['imgURL'] = $result->imgURL;
			$_SESSION['userType'] = $result->userType;

			echo 1;

		} else {
			echo 2;
		}

	}

	public function dashboard()
	{
		if ($_SESSION['name']) {
			$this->load->view('sidebar.php');
			if ($_SESSION['userType'] == 'Teacher') {
				$sql = 'select * from student_teacher st, user u where st.studentID = u.id And st.teacherID =' . $_SESSION['userID'];

				$result = $this->db->query($sql)->result();
				$data['result'] = $result;

				$this->load->view('teacherIndex.php', $data);


			} else {
				$this->load->view('index1.php');

			}
			$this->load->view('template.php');
		} else {
			redirect($this->index());

		}
	}

	public function logout()
	{
		session_destroy();
		redirect($this->index());
	}

	public function register()
	{

		$this->load->view('template.php');
		$this->load->view('register.php');

	}

	public function registerUser()
	{


		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));
		$username = $this->input->post('username');
		$userType = $this->input->post('userType');

		$sql = "select * from user where (email ='" . $email . "' OR name = '" . $username . "')";

		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			echo 2;

		} else {
			$data['email'] = $email;
			$data['password'] = $password;
			$data['name'] = $username;
			$this->db->insert('user', $data);
			echo 1;

		}


	}

	public function userProfile()
	{

		if ($_SESSION['name']) {

			$data = array();

			$sql = "select * from user where id = " . $_SESSION['userID'];
			$result = $this->db->query($sql)->result();
			foreach ($result as $row) {

				$data['firstName'] = $row->name;
				$data['lastName'] = $row->lastName;
				$data['email'] = $row->email;
				$data['address'] = $row->address;
				$data['phoneNumber'] = $row->phoneNumber;
				$data['country'] = $row->country;
				$data['imgURL'] = $row->imgURL;
			}

			$this->load->view('template.php');
			$this->load->view('sidebar.php');
			$this->load->view('profile.php', $data);

		} else {
			redirect($this->index());

		}


	}

	public function upload_file()
	{
		$config['upload_path'] = './uploads/'; // Specify the directory where uploaded files will be stored
		$config['allowed_types'] = 'jpg|jpeg|png'; // Specify the allowed file types
		$config['max_size'] = 2048; // Maximum file size in kilobytes

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {
			$error = $this->upload->display_errors();
			$this->output->set_status_header(500);
			echo $error;
		} else {

			$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];

			$uploaded_image_url = base_url('uploads/' . $file_name);

			$sql = "update user set imgURL = '" . $uploaded_image_url . "' where id =" . $_SESSION['userID'];
			$this->db->query($sql);
			echo $uploaded_image_url;
		}
	}

	function saveProfile()
	{
		$data['name'] = $this->input->post('name');
		$data['lastName'] = $this->input->post('lastName');
		$data['email'] = $this->input->post('email');
		$data['phoneNumber'] = $this->input->post('phoneNumber');
		$data['address'] = $this->input->post('address');
		$data['country'] = $this->input->post('country');

		$condition = array('id' => $_SESSION['userID']);

		$this->db->update('user', $data, $condition);

		if ($this->db->affected_rows() > 0) {
			echo "1";
		} else {
			echo "Update failed!";
		}

	}

	function readJson()
	{

		$this->load->helper('file');


		$uploaded_image_url = base_url('uploads/' . 'world.json');


		$json_data = read_file($uploaded_image_url);

		if ($json_data !== FALSE) {

			$data_array = json_decode($json_data, TRUE);

			echo $json_data;

		} else {
			echo "Failed to read JSON file.";
		}


	}

	function readJson1()
	{
		$category = $_POST['category'];


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://127.0.0.1:5000/get_questions',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
										"category": "' . $category . '"
									}',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
		));

		$json_data = curl_exec($curl);

		curl_close($curl);

		if ($json_data !== FALSE) {
			$data_array = json_decode($json_data, TRUE);

			echo $json_data;
		} else {
			echo "Failed to read JSON file.";
		}


	}

	function quizView()
	{
		if ($_SESSION['name']) {
			$data['category'] = $_GET['category'];
			$this->load->view('template.php');
			$this->load->view('sidebar.php');
			$this->load->view('quiz1.php', $data);

		} else {
			redirect($this->index());
		}
	}

	function teacherquizView()
	{
		if ($_SESSION['name']) {
			$category = $_GET['category'];


			$data['category'] = $_GET['category'];


			$this->load->view('template.php');
			$this->load->view('sidebar.php');
			$this->load->view('teacherquiz.php', $data);

		} else {
			redirect($this->index());
		}
	}

	public function getCategoryQuiz()
	{
		$category = $_POST['category'];
		$sql = "select * from custom_quiz_json order by id desc limit 1";
		$result = $this->db->query($sql)->row();

		$originalData = json_decode($result->data, true);
//		$originalData = $result->data;

		$newData = ["questions" => []];

		foreach ($originalData as $item) {
			$newItem = [
				"id" => $item["index"],
				"question" => $item["output"],
				"video_link" => $item["video_link"],
				"category" => $category,
				"answer" => $item["correct_answer"],
				"choices" => array_column($item["options"], "choice"),
			];
			$newData["questions"][] = $newItem;
		}


		echo json_encode($newData, true);


	}


	function save_statistics()
	{


		$quizData = $this->input->post('quiz_data');

		$this->db->insert('quizstats', $quizData);


	}
	function saveCategory()
	{


		$category = $this->input->post('category');

		$data['name'] = $category;
		$data['userID'] = $_SESSION['userID'];


		$this->db->insert('quizcategory', $data);
echo 1;

	}

	public function add_dummy_data()
	{


		$numRecords = 10000; // Number of dummy records to add

		for ($i = 0; $i < $numRecords; $i++) {
			$totalQuestions = mt_rand(5, 15);
			$score = mt_rand(0, $totalQuestions);
			$data = [
				'userID' => mt_rand(1, 10),
				'category' => 'python',
				'totalQuestions' => $totalQuestions,
				'score' => $score,
				'timeConsumed' => mt_rand(60, 600),
				'percentage' => mt_rand(0, 100),
				'createdDate' => date('Y-m-d H:i:s')
			];

			$this->db->insert('quizstats', $data);
		}

		echo "Dummy data added successfully";
	}

	public function get_user_progress()
	{

		$sqlWhere = '';
		if ($_SESSION['userType'] == 'Teacher') {
			if (isset($_SESSION['studentID'])) {

				if ($_SESSION['studentID'] == 0) {
					$sqlWhere = '';
				} else {
					$sqlWhere = ' And userID =' . $_SESSION['studentID'];

				}

			}
			$sql = "select count(a.id) as score , a.createdDate from quizstats a, student_teacher where userID = studentID $sqlWhere  group by Date(a.createdDate) ";


		} else {
			$sql = "select count(id) as score , createdDate from quizstats where userID = " . $_SESSION['userID'] . " group by Date(createdDate) ";

		}
		$query = $this->db->query($sql);
		$userProgressData = $query->result();


		echo json_encode($userProgressData);
	}

	function getSuggestionOfWebsites()
	{
		$jsonData = $this->input->post('jsonData');

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://localhost:5000/quiz_completed',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($jsonData),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;


	}

	function getQuizCategoryView()
	{

		$sql = "select * from quizcategory";
		$result = $this->db->query($sql);
		$data["category"] = $result->result();

		if ($_SESSION['name']) {
			$this->load->view('template.php');
			$this->load->view('sidebar.php');
			$this->load->view('quizCategory.php', $data);

		} else {
			redirect($this->index());
		}
	}

	function getRegisteredStudents()
	{

		if ($_SESSION['name']) {

			$sql = 'SELECT * FROM user where id in (select studentID from student_teacher where TeacherID = ' . $_SESSION['userID'] . ')';

			$result = $this->db->query($sql);
			$students = $result->result();
			$data['students'] = $students;


			$this->load->view('template.php');
			$this->load->view('sidebar.php');
			$this->load->view('registeredStudents.php', $data);

		} else {
			redirect($this->index());
		}


	}

	function getQuizStats()
	{
		$sql = "select * from quizstats";
		$result = $this->db->query($sql)->result();
		return json_encode($result);
	}

	function getTotalQuiz()
	{
		$sqlWhere = '';
		if ($_SESSION['userType'] == 'Teacher') {
			if (isset($_SESSION['studentID'])) {

				if ($_SESSION['studentID'] == 0) {
					$sqlWhere = '';
				} else {
					$sqlWhere = ' And userID =' . $_SESSION['studentID'];

				}

			}
			$sql1 = "select count(*) as total , ROUND(AVG(percentage), 2) AS averagePercentage from quizstats , student_teacher where userID = studentID $sqlWhere ";
			$sql2 = "select count(*) as total , ROUND(AVG(percentage), 2) AS averagePercentage from quizstats a, student_teacher where  DATE(a.createdDate) = CURDATE() and userID = studentID $sqlWhere ";
			$sql3 = "select count(*) as total , ROUND(AVG(percentage), 2) AS averagePercentage from quizstats a, student_teacher  where  DATE(a.createdDate) =  CURDATE() - INTERVAL 1 DAY and userID = studentID $sqlWhere ";


		} else {
			$sql1 = "select count(*) as total , ROUND(AVG(percentage), 2) AS averagePercentage from quizstats where userID = " . $_SESSION['userID'];
			$sql2 = "select count(*) as total , ROUND(AVG(percentage), 2) AS averagePercentage from quizstats where  DATE(createdDate) = CURDATE() and userID = " . $_SESSION['userID'];
			$sql3 = "select count(*) as total , ROUND(AVG(percentage), 2) AS averagePercentage from quizstats where  DATE(createdDate) =  CURDATE() - INTERVAL 1 DAY and userID = " . $_SESSION['userID'];

		}


		$result1 = $this->db->query($sql1)->row();

		$data['total'] = $result1->total;
		$data['averagePercentage'] = $result1->averagePercentage;

		$sql = "select count(*) as total , ROUND(AVG(percentage), 2) AS averagePercentage from quizstats where  DATE(createdDate) = CURDATE() and userID = " . $_SESSION['userID'];
		$result2 = $this->db->query($sql2)->row();

		$data['totalToday'] = $result2->total;
		$data['averagePercentageToday'] = $result2->averagePercentage;

		$sql = "select count(*) as total , ROUND(AVG(percentage), 2) AS averagePercentage from quizstats where  DATE(createdDate) =  CURDATE() - INTERVAL 1 DAY and userID = " . $_SESSION['userID'];
		$result3 = $this->db->query($sql3)->row();

		$data['totalYesterday'] = $result3->total;
		$data['averagePercentageYesterday'] = $result3->averagePercentage;

		echo json_encode($data);

	}

	public function getWeeklyAveragePercentages()
	{

		$sqlWhere = '';
		if ($_SESSION['userType'] == 'Teacher') {
			if (isset($_SESSION['studentID'])) {

				if ($_SESSION['studentID'] == 0) {
					$sqlWhere = '';
				} else {
					$sqlWhere = ' And userID =' . $_SESSION['studentID'];

				}

			}


			$sql = "SELECT DATE(a.createdDate) AS date, ROUND(AVG(percentage), 2) AS avg_percentage
        FROM quizstats a , student_teacher
        WHERE  studentID = userID  AND teacherID =" . $_SESSION['userID'] . "  $sqlWhere  AND a.createdDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        GROUP BY DATE(a.createdDate)";


		} else {
			$sql = "SELECT DATE(createdDate) AS date, ROUND(AVG(percentage), 2) AS avg_percentage
        FROM quizstats
        WHERE userID = " . $_SESSION['userID'] . " AND createdDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        GROUP BY DATE(createdDate)";
		}


		$query = $this->db->query($sql);
		$results = $query->result();
		$startDate = new DateTime();
		$startDate->modify('-7 days');
		$dateInterval = new DateInterval('P1D');
		$datePeriod = new DatePeriod($startDate, $dateInterval, 6);

		$weeklyAverages = [];
		foreach ($datePeriod as $date) {
			$formattedDate = $date->format('Y-m-d');
			$weeklyAverages[$formattedDate] = 0;
		}

		foreach ($results as $row) {
			$formattedDate = $row->date;
			$avgPercentage = $row->avg_percentage;
			$weeklyAverages[$formattedDate] = $avgPercentage;
		}

		echo json_encode($weeklyAverages);
	}

	public function fetchQuizDataCategory()
	{

		$sqlWhere = '';
		if ($_SESSION['userType'] == 'Teacher') {
			if (isset($_SESSION['studentID'])) {

				if ($_SESSION['studentID'] == 0) {
					$sqlWhere = '';
				} else {
					$sqlWhere = ' And userID =' . $_SESSION['studentID'];

				}

			}
			$sql = "SELECT
    q.category,
    DATE(q.createdDate) AS createdDate,
    COUNT(*) AS count
FROM
    quizstats q
JOIN
    student_teacher st ON q.userID = st.studentID
WHERE
    
     DATE(q.createdDate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
$sqlWhere
GROUP BY
    q.category,
    DATE(q.createdDate)
ORDER BY
    createdDate;
";


		} else {
			$sql = 'SELECT `category`, date(createdDate) as createdDate, COUNT(*) as count FROM `quizstats` WHERE Date(createdDate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) and `userID` = ' . $_SESSION['userID'] . ' GROUP BY `category`, Date(createdDate) ORDER BY `createdDate`';

		}
		$query = $this->db->query($sql);


		echo json_encode($query->result());


	}

	public function fetchQuizDataCategoryScore()
	{


		$sqlWhere = '';
		if ($_SESSION['userType'] == 'Teacher') {
			if (isset($_SESSION['studentID'])) {

				if ($_SESSION['studentID'] == 0) {
					$sqlWhere = '';
				} else {
					$sqlWhere = ' And userID =' . $_SESSION['studentID'];

				}

			}
			$sql = "SELECT
    q.category,
    DATE(q.createdDate) AS createdDate,
    ROUND(AVG(percentage), 2) as average_score
FROM
    quizstats q
JOIN
    student_teacher st ON q.userID = st.studentID
WHERE
    
     DATE(q.createdDate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
$sqlWhere
GROUP BY
    q.category,
    DATE(q.createdDate)
ORDER BY
    createdDate;
";


		} else {
			$sql = 'SELECT `category`, date(createdDate) as createdDate, ROUND(AVG(percentage), 2) as average_score FROM `quizstats` WHERE Date(createdDate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) and `userID` = ' . $_SESSION['userID'] . ' GROUP BY `category`, Date(createdDate) ORDER BY `createdDate`';

		}
		$query = $this->db->query($sql);


		echo json_encode($query->result());


	}

	public function updateSession()
	{
		$studentID = $this->input->post('user');

		$_SESSION['studentID'] = $studentID;
	}

	public function generateQuizView()
	{

		$sql = "select * from quizcategory where userID = ".$_SESSION['userID'];
		$result = $this->db->query($sql);
		$data['category']= $result->result();

		$this->load->view('template.php');
		$this->load->view('sidebar.php');
		$this->load->view('generateQuizView.php',$data);

	}

	public function save_quiz_data()
	{
//		$post_data = file_get_contents('php://input');


		if (!empty($_POST)) {
			$user_id = isset($_SESSION['userID']) ? $_SESSION['userID'] : null; // Get user ID from session

			// Other details
			$category = 'Some Category';
			$status = 1;

			if ($user_id !== null) {

				$insert_data = array(
					'data' => $_POST['updatedQuizData'],
					'userID' => $user_id,
					'category' => $_POST['quizCategory'],
					'status' => $status,
					'name' => $_POST['quizName']
				);

				$this->db->insert('custom_quiz_json', $insert_data);
			}


		}
	}

	public function getNewStudents()
	{
		$teacherId = $_SESSION['userID'];
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('userType', 'Student');
		$this->db->where("id NOT IN (SELECT studentID FROM student_teacher WHERE teacherID = $teacherId)");
		$query = $this->db->get();
		$students = $query->result();

		echo json_encode($students);


	}

	public function addStudent()
	{

		$studentID = $this->input->post('selectedStudents');

		$data['studentID'] = $studentID;
		$data['teacherID'] = $_SESSION['userID'];

		$this->db->insert('student_teacher', $data);

		echo 1;


	}

	public function quizList()
	{

		if ($_SESSION['name']) {

			$sql = 'SELECT * FROM custom_quiz_json where  userID = ' . $_SESSION['userID'] . ' order by id desc ';

			$result = $this->db->query($sql);
			$quiz = $result->result();
			$data['quiz'] = $quiz;


			$this->load->view('template.php');
			$this->load->view('sidebar.php');
			$this->load->view('customQuiz.php', $data);

		} else {
			redirect($this->index());
		}


	}

	public function process_pdf()
	{
		$config['upload_path'] = './uploads/'; // Define your upload directory
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = 2048; // 2MB max file size (adjust as needed)

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('pdf_file')) {
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('error', $error);
			redirect('pdfcontroller');
		} else {
			$data = $this->upload->data();
			$pdfText = $this->pdf_processing->pdf2text($data['full_path']);
			unlink($data['full_path']); // Remove the uploaded PDF file
			echo json_encode($pdfText);

//			$this->load->view('pdf_result', ['pdfText' => $pdfText]);
		}
	}

	public function getCategoresList()
	{
		if ($_SESSION['name']) {
			$sql = 'SELECT * FROM quizCategory where  userID = ' . $_SESSION['userID'] . ' order by id desc ';
			$result = $this->db->query($sql);
			$quiz = $result->result();
			$data['quiz'] = $quiz;
			$this->load->view('template.php');
			$this->load->view('sidebar.php');
			$this->load->view('categories.php', $data);
		} else {
			redirect($this->index());
		}
	}

}
