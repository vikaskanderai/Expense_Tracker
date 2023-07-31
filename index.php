<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+SA+Beginner:wght@400;500;600&family=Poppins:wght@300&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

 
<body>
    <div class="header">
        <h4><strong>Expense Tracker</strong></h4>
    </div>
    
    <div class="flex">
        <h3>Enter Transaction</h3> 
        <div class="outer">
            
            <form action="submit.php" method="post" id="data">
                <?php 
                    $status="";
                    if(isset($_GET['status'])){
                        $status=$_GET['status'];
                    }
                    else{
                        $status="";
                    }
                ?>
                <p> <?php echo $status?></p>
                <div class="container">
                    
                    <div class="desc">
                        <label for="amount">Enter the amount</label>
                    </div>
                    <div class="val">
                        <input type="number" name="amount" id="amount" placeholder="0.0">
                    </div>


                    <div class="desc">
                        <label for="name">Sent to/ Received from</label>
                    </div>
                    <div class="val">
                        <input type="text" name="name" id="name" placeholder="Enter the name">
                    </div>
                    
                    
                    <div class="desc">
                        <label for="purpose">Purpose</label>
                    </div>
                    <div class="val">
                        <select name="purpose" id="purpose">
                            <option class="selectOpt" value="">Select</option>
                            <option value="salary">Salary</option>
                            <option value="investment">Investment</option>
                            <option value="shopping">Shopping</option>
                            <option value="food">Food</option>
                            <option value="fuel">Fuel</option>
                            <option value="gifts">Gifts</option>
                            <option value="Travel">Travel</option>
                            <option value="entertainment">Entertainment</option>
                            <option value="misc">MISC</option>
                            
                        </select>
                    </div>


                    <div class="desc">
                        <label for="type">Transaction Type</label>
                    </div>
                    <div class="val">
                        <div style="display: inline;">
                            <input type="radio" id="credit" name="type" value="credit">                    
                            <label for="cash">Credit</label>
                            <input type="radio" id="debit" name="type" value="debit">
                            <label for="card">Debit</label>
                        </div>
                    </div>
        

                    <div class="desc">
                        <label for="mode">Mode of Payment</label>
                    </div>
                    <div class="val">
                        <div style="display: inline;">
                            <input type="radio" id="cash" name="mode" value="cash">                    
                            <label for="cash">Cash</label>
                            <input type="radio" id="card" name="mode" value="card">
                            <label for="card">Card</label>
                            <input type="radio" id="upi" name="mode" value="upi">
                            <label for="upi">UPI</label>
                        </div>
                    </div>
                    
        
                    
                    <div class="desc">
                        <label for="date">Transaction Date</label>
                    </div>
                    <div class="val">
                        <input type="date" name="date" id="date">
                    </div>
        
                </div>
        
                <input class="btn btn-primary" type="submit" value="Submit" name="submit-btn" id="submit">
            </form>
        </div>


        <?php
            $server="localhost";
            $username="root";
            $password="";
    
            $con=mysqli_connect($server,$username,$password);
    
            if(!$con){
                die("Connection to database failed due to ".mysqli_connect_error());
            }  

            $delete_query = "DELETE FROM expense_tracker.transaction WHERE amount = 0";
            $con->query($delete_query);

            $credit = "SELECT SUM(amount) AS total_credit FROM expense_tracker.transaction WHERE type='credit'";
            $result=$con->query($credit);
            $row= mysqli_fetch_assoc($result);
            $total_credit= $row['total_credit'];

            $debit = "SELECT SUM(amount) AS total_debit FROM expense_tracker.transaction WHERE type='debit'";
            $result=$con->query($debit);
            $row= mysqli_fetch_assoc($result);
            $total_debit= $row['total_debit'];

            $total_balance=$total_credit-$total_debit;
            $total_transaction=$total_credit+$total_debit;

            $credit_percent = $total_credit/$total_transaction *100;
            $debit_percent = $total_debit/$total_transaction *100;
            
            mysqli_close($con);
        ?> 


    
        <div class="container2">
            <h3>Expense Summary</h3>
    
            <div class="overview">
                <div class="summary">
                    <label class="desc">Total credit</label>
                    <label style="color: green;"><?php echo $total_credit; ?>/-</label>
                    <label class="desc">Total debit</label>
                    <label style="color: red;"><?php echo $total_debit; ?>/-</label>
                    <label class="desc">Balance</label>
                    <label><?php echo $total_balance; ?>/-</label>
                </div> 
            </div>
    
            <div class="overview">
                <div class="chartContainer">
                    <canvas class="myChart"></canvas>
                </div>            
            </div>
    
        </div>

        <div class="list">
            <h3>My Transactions</h3>

                <?php
                    $server="localhost";
                    $username="root";
                    $password="";
            
                    $con=mysqli_connect($server,$username,$password);
            
                    if(!$con){
                        die("Connection to database failed due to ".mysqli_connect_error());
                    }  

                    $fetch = "SELECT * from expense_tracker.transaction ORDER BY date DESC";
                    $result=mysqli_query($con,$fetch);

                    while($row=mysqli_fetch_assoc($result)){

                        if($row['type']=='credit'){
                            $border= '3px solid rgb(0, 180, 0)';
                        }
                        else{
                            $border= '3px solid rgb(254, 44, 44)';
                        }
                        $date_converted= date('d-m-Y',strtotime($row['date']));
                        if($row['amount']>0){
                            //echo $id;
                            echo 
                                '<div class="trans">'.
                                    '<li class="info" style="border:'.$border.';">'.
                                        '<div class="pay">'.
                                            '<div class="left">'.
                                                '<h2>'."₹".$row['amount'].'</h2>'.
                                                '<p>'."(".'<span>'.$row['mode'].'</span>'.")".'</p>'.
                                            '</div>'.
                                        '</div>'.
                                        '<p>'."Name: ".'<span>'.$row['name'].'</span>'.'</p>'.
                                        '<p>'."Purpose: ".'<span>'.$row['purpose'].'</span>'.'</p>'.
                                        '<p>'."Date: ".'<span>'.$date_converted.'</span>'.'</p>'.
                                    
                                    '</li>'.
                                '</div>';
                        }
                    }
                    
                    mysqli_close($con);
                ?> 

        </div>


        


    </div>
    

    


    <footer>
        Made with ❤ by Kanderai 
    </footer>

    <script>
        var credit_per='<?php echo $credit_percent;?>';
        var debit_per='<?php echo $debit_percent;?>';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="index.js"></script>
</body>
</html>