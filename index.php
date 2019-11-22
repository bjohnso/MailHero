<?php

if (isset($_POST['email'])){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mailhero";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO client (clientName, clientEmail) VALUES ('";
    $sql .= $_POST['name'];
    $sql .= "','";
    $sql .= $_POST['email'];
    $sql .= "')";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "mailhero";

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }

   $sql = 'SELECT clientName, clientEmail FROM client';

   $clientResult = $conn->query($sql);

   $sql = 'SELECT emailName FROM email';

   $messageResult = $conn->query($sql);

   $conn->close();
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <title>Document</title>
</head>
<body>
    
<div class="row">
<nav class="blue darken-3">
    <div class="container">
        <div class="nav-wrapper">
        <a href="/dashboard" class="brand-logo center">Mail Hero</a>
        <a id="sideNavBtn" href="#" data-activates="main-menu" class="button-collapse show-on-large"><i class="fa fa-bars"></i></a>
            <ul class="sidenav" id="main-menu">
                <li>
                    <a class="btn red darken-1" href="mail.php"><i class="fab fa-google left"></i> Email Creator</a>
                </li>
                <li>
                    <a class="btn pink darken-1" href="index.php"><i class="fab fa-instagram left"></i> Mail List</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</div>


<div class="row center-align valign-wrapper">

    <div class="col s12">
        <form action="#">
            <ul class="collection with-header" style="overflow:scroll; height: 60vh">
                <li class="collection-header">
                    <div class= "row valign-wrapper">
                        <div class="col s4">
                            
                        </div>
                        <div class="col s4 center-align">
                            <h4>Mail List</h4>
                        </div>
                        <div class="col s4">
                        <label>
                            <input type="checkbox" />
                            <span>Select All</span>
                        </label>
                        </div>
                    </div>
                </li>
                <?

                if (isset($clientResult) && $clientResult->num_rows > 0) {
                    // output data of each row
                    while($row = $clientResult->fetch_assoc()) {
                        $str = "<li class='collection-item'>";
                        $str .= "<div class= 'row valign-wrapper'>";
                        $str .= "<div class='col s4'>";
                        $str .= $row["clientName"];
                        $str .= "</div><div class='col s4'>";
                        $str .= $row["clientEmail"];
                        $str .= "</div><div class='col s4'><label><input type='checkbox' /><span></span></label></div></div></li>";
                        echo $str;
                    }
                }
                ?>
            </ul>
        </form>
    </div>

</div> 

<form action="post">
    <div class="row valign-wrapper">    
                <div class="col s3 offset-s5 left-align">
                    <div class="input-field col s12">
                        <select>
                        <option value="" disabled selected>Message</option>
                            <?
                                if (isset($messageResult) && $messageResult->num_rows > 0) {
                                    // output data of each row
                                    $count = 1;
                                    echo "awe";
                                    while($row = $messageResult->fetch_assoc()) {
                                        $str = "<option value=";
                                        $str .= $count; 
                                        $str .= "><input id='hiddenCheckBox";
                                        $str .= $count;
                                        $str .= "' type='text' hidden='hidden'";
                                        $str .= " value= '";
                                        $str .= $row["emailName"];
                                        $str .= "'/>";
                                        $str .= $row["emailName"];
                                        $str .= "</option>";
                                        echo $str;
                                        $count++;
                                    }
                                }
                            ?>
                        </select>
                        <label>Message</label>
                    </div>
                </div>
                <div class="col s4 left-align">
                    <button id = "send_btn" class="btn waves-effect waves-light" type="button">Send to Selected</button>
                </div>
    </div>
</form>

<form action="index.php" method="POST">
    <div class="row valign-wrapper">
                <div class="col s3 offset-s2 right-align">
                    <div class="input-field">
                        <input type="text" class="validate" name = "name" required/>
                        <label for = "name">Name</label>
                    </div>
                </div>          
                <div class="col s3 left-align">
                    <div class="input-field">
                        <input type="email" class="validate" name="email" required/>
                        <label for = "email">Email</label>
                    </div>
                </div>
                <div class="col s4 left-align">
                    <button class="btn waves-effect waves-light" type="submit">Add new Address</button>
                </div>
    </div>
</form>

<form action="post">
<div class="row valign-wrapper">
        
            <div class="col s6 right-align">
                <p style="color:red">I hope you know what you're doing!</p>
            </div>
            <div class="col s6 left-align">
                <button class="btn waves-effect waves-light" type="submit">Delete All</button>
            </div>
</div>
</form>

<footer class="page-footer blue darken-3">
          <div class="footer-copyright blue darken-3">
            <div class="container">
            © 2019 Mail Hero Copyright Brandon Johnson
            </div>
          </div>
</footer>


<script>
    document.addEventListener('DOMContentLoaded', function() {
                //Side-Nav
                var sideNavs = document.querySelectorAll('.sidenav');
                var sideNavI = M.Sidenav.init(sideNavs);
                //Select
                var elems = document.querySelectorAll('select');
                var instances = M.FormSelect.init(elems);
                //sendBtn
                var sendBtn = document.getElementById('send_btn');
                //sideNav
                var sideNavBtn = document.getElementById('sideNavBtn');
                if (sideNavBtn !== undefined && sideNavBtn){
                    sideNavBtn.onclick = function () {
                        for (var i = 0; i < sideNavI.length; i++){
                            sideNavI[i].open();
                        }
                    }
                }
                var boxes = document.querySelectorAll('option');
                var checked = [];
                if (sendBtn !== undefined && sendBtn){
                    sendBtn.onclick = function(){
                        for (var i = 0; i < boxes.length; i++){
                            if (boxes[i].checked == true){
                                checked.push(boxes[i].firstElementChild.value);
                                console.log(checked[i]);
                            }
                        }
                    }
                }
                
            });

    </script>
    
</body>
</html>