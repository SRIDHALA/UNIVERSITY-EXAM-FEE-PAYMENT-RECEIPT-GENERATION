<?php

    include 'header.php';
    SESSION_START();
    if(isset($_POST['submit'])){
        $registerno = $_POST['regno'];

        $name = "SELECT sname,email,prgm_name,dept_name FROM u_student s INNER JOIN u_prgm p ON s.prgm_id = p.prgm_id INNER JOIN u_dept d ON d.dept_id = p.dept_id WHERE regno = '$registerno' ";
        $result1 = mysqli_query($conn,$name);
        $x = mysqli_fetch_assoc($result1);

        $_SESSION['r_no'] = $registerno;
        $_SESSION['stuname'] = $x['sname'];
        $_SESSION['s_email'] = $x['email'];
        $_SESSION['pr_name'] = $x['prgm_name'];
        $_SESSION['dep_name'] = $x['dept_name'];

        $sub = "SELECT c.course_code,course_name,course_type FROM u_exam_regn e INNER JOIN u_course c ON e.course_code = c.course_code WHERE regno='$registerno'";
        $result4 = mysqli_query($conn,$sub);
        $total_fees = 0;
        $rowcount = mysqli_num_rows($result4);
        $_SESSION['total_sub'] = $rowcount;

        while ($row2 = mysqli_fetch_array($result4))
        {
            if ($row2['course_type'] == 'TY')
			{
				$row2['course_type'] = 'Theory';
				$fee = 250;
			}
		    if ($row2['course_type'] == 'LB')
			{
				$row2['course_type'] = 'Laboratory';
				$fee = 350;
			}
			if ($row2['course_type'] == 'MC')
			{
				$row2['course_type'] = 'Mandatory Course';
				$fee = 0;
			}
            $total_fees = $total_fees + $fee;
        }
        $total_fees = $total_fees + 100 +50;
        $_SESSION['fees'] = $total_fees;

    
    }

?>  