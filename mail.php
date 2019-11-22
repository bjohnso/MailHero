<?php


if (isset($_POST['emailMessage'])){
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

    $sql = "INSERT INTO email (emailName, emailSender, emailMessage) VALUES ('";
    $sql .= $_POST['emailName'];
    $sql .= "','";
    $sql .= $_POST['emailSender'];
    $sql .= "','";
    $sql .= $_POST['emailMessage'];
    $sql .= "')";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

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

    <!-- Theme included stylesheets -->
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

    <!-- Main Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
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

<div style = "height:60vh" id="editor"></div>
     
<form method="POST" action="mail.php" id="newEmailForm">
    <div class="row valign-wrapper">
                <input id="quillHiddenInput" type="text" name="emailMessage" hidden="hidden">
                <div class="col s3 offset-s2 right-align">
                    <div class="input-field">
                        <input type="text" class="validate" name = "emailName" required/>
                        <label for = "name">Message Name</label>
                    </div>
                </div>          
                <div class="col s3 left-align">
                    <div class="input-field">
                        <input type="email" class="validate" name="emailSender" required/>
                        <label for = "email">Sender Address</label>
                    </div>
                </div>
                <div class="col s4 left-align">
                    <button type="Button" class="btn waves-effect waves-light" id="save">Add New Email</button>
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
                //Modals
                var modals = document.querySelectorAll('.modal');
                var modalI = M.Modal.init(modals);
                //Tabs
                var tabs = document.querySelectorAll('.tabs');
                var tabsI = M.Tabs.init(tabs);
                //Side-Nav
                var sideNavs = document.querySelectorAll('.sidenav');
                var sideNavI = M.Sidenav.init(sideNavs);
                //Select
                var elems = document.querySelectorAll('select');
                var instances = M.FormSelect.init(elems);
                //Date-Picker
                var elems = document.querySelectorAll('.datepicker');
                var instances = M.Datepicker.init(elems, {
                    yearRange: [1900, 2100]
                });
                //Buttons
                //sideNav
                var sideNavBtn = document.getElementById('sideNavBtn');
                if (sideNavBtn !== undefined && sideNavBtn){
                    sideNavBtn.onclick = function () {
                        for (var i = 0; i < sideNavI.length; i++){
                            sideNavI[i].open();
                        }
                    }
                }
                //modal
                var piBtn = document.getElementById('profileImageSelectorBtn');
                if (piBtn !== undefined && piBtn){
                    piBtn.onclick = function () {
                        for (var i = 0; i < modalI.length; i++){
                            if (modalI[i].id == "profileImageSelector"){
                                modalI[i].open();
                            }
                        }
                    }
                }
                //profileImageSelect
                var piSelected = document.querySelectorAll('.profileImageSelected');
                for (var i = 0; i < piSelected.length; i++){
                    var url = piSelected[i].firstElementChild.src
                    piSelected[i].onclick = (function(url) {return function() {
                        for (var i = 0; i < modalI.length; i++){
                            if (modalI[i].id == "profileImageConfirm"){
                                document.getElementById("profileImageConfirmLink").src = url;
                                document.getElementById("profileImage").value = url;
                                modalI[i].open();
                            }
                        }
                    };})(url);
                }
                var piAccept = document.getElementById("profileImageSelectorAcceptBtn");
                if (piAccept){
                    piAccept.onclick = function() {
                        document.getElementById("profileImageForm").submit();
                        for (var i = 0; i < modalI.length; i++){
                                modalI[i].close();
                            }
                    }
                }
                //Quill
                var editor = document.getElementById('editor');
                var quill;
                if (editor){
                    quill = new Quill('#editor', {
                        modules: { 'syntax': false,
                                'toolbar': [
                                [{ 'font': [] }, { 'size': [] }],
                                [ 'bold', 'italic', 'underline', 'strike' ],
                                [{ 'color': [] }, { 'background': [] }],
                                [{ 'script': 'super' }, { 'script': 'sub' }],
                                [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block' ],
                                [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
                                [ 'direction', { 'align': [] }],
                                [ 'link', 'image', 'video', 'formula' ],
                                [ 'clean' ]
                        ] },
                        theme: 'snow'
                    });
                }
                //AboutEdit
                var quillInput = document.getElementById('quillHiddenInput');
                var submitBtn = document.getElementById('save');
                if (submitBtn && quillInput){
                    submitBtn.onclick = function() {
                        quillInput.value = quill.getContents();;
                        //console.log(quillInput.value);
                        //quillInput.value = JSON.stringify(quill.getText());
                        document.getElementById("newEmailForm").submit();
                    }
                }
                
            });

    </script>

</body>
</html>