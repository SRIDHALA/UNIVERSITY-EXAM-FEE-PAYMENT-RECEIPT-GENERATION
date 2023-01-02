<?php
	
    include 'header.php';
    //include 'data.php';
	//echo "$_SESSION[c_code]";
    /*echo "$_SESSION[stuname]";
    echo "$_SESSION[pr_name]";
    echo "$_SESSION[dep_name]";
    echo "$_SESSION[s_email]";*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hall Ticket</title>
  <link rel="stylesheet" href="style.css">
  <script src=
"https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
    </script>
</head>

<body>
    <?php 
        include 'data.php';

    ?>
	<button id="button">Generate PDF</button>
	<div class="page" id  = "makepdf">
		<h1></h1>
		<div>
			<div class = "logo-img">
				<img src = "ptu-logo.png" alt = "ptu-logo" class = "logo">
			</div>
			<br>
			<div class = "heading_text">
				<p class="thicker "> PUDUCHERRY TECHNOLOGICAL UNIVERSITY </p>
				<p style="font-family:Helvetica;font-size:15px;text-align:center;line-height:0.01;"> EXAMINATION WING </p>
				<p style="font-family:Helvetica;font-size:15px;text-align:center;line-height:0.6;"> SEMESTER EXAMINATIONS -- NOV 2022 </p>
				<p style="font-family:Arial;font-weight:650;font-size:22px;text-align:center;line-height:1.5;color:darkblue;"> HALL TICKET </p>
				<br>
			</div>
			<div class="photo">
                <!-- to display the pic of the selected student -->
                <?php
                    $src = "18-BT-IMG\\".$_SESSION['r_no'].".png";
                    echo "<img src=$src alt = 'photo' class = 'stu_photo'>"
                ?>
        </div>
		</div>

		
		
		
		<div class="float_left">
			<ul>
			<li> <b class = "names">STUDENT NAME</b> <t>: <?php echo "$_SESSION[stuname]" ?> </t> </li> <br>
			<li> <b class = "names">REGISTER NO</b> <t>: <?php echo "$_SESSION[r_no]" ?> </t> </li> <br>
			<li> <b class = "names">EMAIL</b> <t>: <?php echo "$_SESSION[s_email]" ?> </t> </li> <br>
			<li> <b class = "names">INSTITUTE</b> <t>: <?php echo "PTU" ?>  </t> </li> <br>
			<li> <b class = "names">PROGRAMME</b> <t>: <?php echo "$_SESSION[pr_name]" ?> </t> </li> <br>
			<li> <b class = "names">DEPARTMENT</b> <t>: <?php echo "$_SESSION[dep_name]" ?> </t> </li> <br>
			<li> <b class = "names">SPECIALIZATION</b> <t>: <?php echo "NA" ?> </t> </li> <br>
			</ul>
		</div>
		
		<div class="float_right">
			<ul>
            <li> <b class = "names">TOTAL NUMBER OF SUBJECTS</b> <t>: <?php echo "$_SESSION[total_sub]" ?> </t> </li> <br>
            <li> <b class = "names">APPLICATION FEE(₹)</b> <t>: <?php echo "50" ?> </t> </li> <br>
            <li> <b class = "names">GRADE SHEET(₹)</b> <t>: <?php echo "100" ?> </t> </li> <br>
            <li> <b class = "names">TOTAL FEES PAYABLE(₹)</b> <t>: <?php echo "$_SESSION[fees]" ?> </t> </li> <br>
            <li> <b class = "names">EXAM FEES PAID(₹)</b> <t>: <?php echo "$_SESSION[fees]" ?> </t> </li> <br>
            <li> <b class = "names">PAYMENT ID</b> <t>: </t> </li> <br>
            <li> <b class = "names">GENERATED ON</b> <t>: <?php echo date('d-m-Y') ?> </t> </li> <br>
			</ul>
		</div>
	
		<h2></h2>
		
		<div>
			<?php
				echo "<table>";
					echo "<tr>";
						echo "<th>SUBJECT CODE</th>";
						echo "<th>SUBJECT NAME</th>";
						echo "<th>SEMESTER</th>";
						echo "<th>THEORY/LAB</th>";
						echo "<th>FEE(₹)</th>";
					echo "</tr>";

					$sub = "SELECT c.course_code,course_name,course_type FROM u_exam_regn e INNER JOIN u_course c ON e.course_code = c.course_code WHERE regno='$_SESSION[r_no]'";
        			$result2 = mysqli_query($conn,$sub);


					$sem = "SELECT curr_sem FROM u_student WHERE regno = '$_SESSION[r_no]'";
					$result3 = mysqli_query($conn,$sem);
					$z = mysqli_fetch_assoc($result3);
				
					$total_fees = 0;
					while ($row = mysqli_fetch_array($result2))
					{
						if ($row['course_type'] == 'TY')
						{
							$row['course_type'] = 'Theory';
							$fee = 250;
						}
						if ($row['course_type'] == 'LB')
						{
							$row['course_type'] = 'Laboratory';
							$fee = 350;
						}
						if ($row['course_type'] == 'MC')
						{
							$row['course_type'] = 'Mandatory Course';
							$fee = 0;
						}

						//$total_fees = $total_fees + $fee;

						echo "<tr>";
							echo "<td>" .$row['course_code']. "</td>";
							echo "<td>" .$row['course_name']. "</td>";
							echo "<td>" .$z['curr_sem']. "</td>";
							echo "<td>" .$row['course_type']. "</td>";
							echo "<td>" .$fee. "</td>";
						echo "</tr>";
					}
				echo "</table>";
				//echo $total_fees;
			?>
		
		</div>
		<div class = "bottomleft1"> <img src = "director.png" alt = "director" class = "logo1"> </div>
		<div class = "bottomright">Signature of the Student</div>
		<div class = "bottomleft">Director(Examinations)<br><br>Dated : <?php echo date('d-m-Y') ?></div>
		<div class = "foot">NOTE : This Hall ticket is valid subject to fulfilling the attendance criteria</div>
		
	</div>
	<script>
        var button = document.getElementById("button");
        var makepdf = document.getElementById("makepdf");
  
        button.addEventListener("click", function () {
            html2pdf().from(makepdf).save();
        });
    </script>


</body>
</html>
