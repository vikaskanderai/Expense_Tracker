<?php
    $status="";
    if(isset($_POST['type'])&&isset($_POST['mode'])&&isset($_POST['date'])&&isset($_POST['purpose'])){
        $server="localhost";
        $username="root";
        $password="";

        $con=mysqli_connect($server,$username,$password);

        if(!$con){
            die("Connection to database failed due to ".mysqli_connect_error());
        }

        $amount= $_POST['amount']; 
        $name= $_POST['name'];
        $purpose= $_POST['purpose'];
        $type= $_POST['type'];
        $mode= $_POST['mode'];
        $date= $_POST['date'];

        if($amount<1){
            $status= "Amount must be greater than 0!!";
            header("Location: index.php?status=".urldecode($status));
            exit;
        }
        else{
            $insert_query ="INSERT INTO expense_tracker.transaction (`amount`, `name`, `purpose`, `type`, `mode`, `date`) VALUES ('$amount', '$name', '$purpose', '$type', '$mode', '$date')";
            $amount= NULL;

            if($con->query($insert_query)==true){
                echo "successfully Inserted"; 
            }
            else{
                echo "Error:$sql<br>$con->error";
            }
            $status="Transaction created!!!";
        }

        $con->close();
        
    }
    else{
        $status= "Enter all the details!!";
    }

    header("Location: index.php?status=".urldecode($status));
    exit;

?>





