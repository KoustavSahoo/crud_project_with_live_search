<?php

require 'dbconnect.php';


//to insert
if(isset($_POST['save_student']))
{
    $name =$_POST['name'];
    $email = $_POST['email'];
    $phone =  $_POST['phone'];
    $course =$_POST['course'];

    if($name == NULL || $email == NULL || $phone == NULL || $course == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "INSERT INTO students (name,email,phone,course) VALUES ('$name','$email','$phone','$course')";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Student Not Created'
        ];
        echo json_encode($res);
        return;
    }
}



//for update

if(isset($_POST['update_student']))
{
    $student_id =$_POST['student_id'];

    $name = $_POST['name'];
    $email =$_POST['email'];
    $phone =$_POST['phone'];
    $course = $_POST['course'];

    if($name == NULL || $email == NULL || $phone == NULL || $course == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE students SET name='$name', email='$email', phone='$phone', course='$course' 
                WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Student Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}



       //edit id and fetch the data
       
if(isset($_GET['eid']))
{
    $student_id =$_GET['eid'];

    $query = "SELECT * FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $student = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Student Fetch Successfully by id',
            'data' => $student
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Student Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}






//delete

if(isset($_POST['delete_student']))
{
    $student_id =$_POST['del_id'];

    $query = "DELETE FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Student Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}



// for live-search
if(isset($_POST['input'])){
    $input=$_POST['input'];
    $sql="SELECT * FROM `students` WHERE `name` LIKE '$input%'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){?>
        <table id="myTable" class="table table-bordered table-striped">
        <thead>
        <tr>
        <td>ID</td>
        <td>NAME</td>
        <td>EMAIL</td>
        <td>PHONE</td>
        <td>COURSE</td>
        </tr>
        </thead>
        <?php
        foreach($result as $row){?>
            <tbody>
                <tr>
                    <td><?php echo $row['id']?></td>
                    <td><?php echo $row['name']?></td>
                    <td><?php echo $row['email']?></td>
                    <td><?php echo $row['phone']?></td>
                    <td><?php echo $row['course']?></td>
                </tr>
            </tbody>

        <?php      
        }
        ?>
        </table>

<?php
    }else{
        echo "<h6 class='text-danger text-center'> No Data Found </h6>";
    }
}

?>