<?php
include 'connection.php';

if(isset($_POST['fname'])){
    $name = $_POST['fname'];
    $country = $_POST['country'];
    $url = $_POST['url'];
    $team_type = $_POST['team_type'];
    $players = $_POST['players'];
    $gamerounds = $_POST['gamerounds'];

    $image = $_FILES['image'];
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];  

    $folder = "img/".$filename; 

    $sql = "INSERT INTO `data` (`name`,`country`, `url`, `team_type`, `players`, ` rounds`,`image`)VALUES('$name','$country','$url','$team_type','$players','$gamerounds','$folder')";
   
    // echo $sql;
    $result = mysqli_query($conn,$sql);
    // var_dump( $result);
   
    if($result){
       echo"inserted";

    }else{
        echo "failed";
    }

    // Add the image to the "img" folder
    if (move_uploaded_file($tempname, $folder)) {

        $msg = "Image uploaded successfully";

    }else{

        $msg = "Failed to upload image";

}
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form validation using procedure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="container-fluid text-dark ">
        <h2 class="text-center my-2">Registration Form</h2>
    </div>
    <div class="container bg-dark text-light py-2 w-50 ">

        <!-- form starts here  -->
        <form class="m-3 p-4 " action="#" method="post" id="form" enctype="multipart/form-data">

            <div class="mb-3" id="name_div">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" name="fname" class="form-control" id="fname" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="inputState" class="form-label">Country</label>
                <select id="inputState" class="form-select" name="country" id="country">

                    <!-- fetch all countries data from db here  -->

                    <?php  
                    $sql = "select * from countries"; 
                    $result = mysqli_query($conn,$sql);
                    
                        while($rows = mysqli_fetch_array($result)){?>
                    <option value='<?php  echo "$rows[0]"?>'>
                        <?php  echo "$rows[1]"?>
                    </option>
                    <?php   }
                  
                    ?>
                    <!-- fetch all countries data from db here  -->

                </select>
            </div>

            <div class="mb-3" id="url_test">
                <label for="url" class="form-label">Preview Url</label>
                <input type="url" name="url" class="form-control" id="url" aria-describedby="emailHelp">
            </div>

            <div class="mb-3" id="team_test">
                <label for="teamtype" class="form-label">Team Type</label>
                <select id="teamtype" class="form-select" name="team_type">
                    <option value="Please Select" selected>Please Select</option>
                    <option value="Solo">Solo</option>
                    <option value="Duo">Duo</option>
                    <option value="Squad">Squad</option>
                    <option value="Clash">Clash</option>
                </select>
            </div>
            <div class="mb-3" id="player_test">
                <label for="players" class="form-label">Max number of players</label>
                <input type="number" name="players" class="form-control" id="players" aria-describedby="emailHelp">
            </div>


            <div class="mb-3" id="rounds_test">
                <label for="gamerounds" class="form-label">Game Rounds</label>
                <select id="gamerounds" class="form-select" name="gamerounds">
                    <option value="Please Select" selected>Please Select</option>
                    <option value="1">Round-1</option>
                    <option value="2">Round-2</option>
                    <option value="3">Round-3</option>
                </select>
            </div>

            <div class="mb-3" id="img_test">
                <label for="formFile" class="form-label">Image upload</label>
                <input class="form-control" type="file" id="image" name="image" accept=".jpg,.jpeg,.png">
            </div>

            <input type="button" id="button" value="Submit" class="btn btn-primary">
    </div>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#button").click(function () {
                // $( "#form" ).submit();
                if (namevalidation() == true && urlval() == true && teamval() == true && playersval() == true && groundsval() == true && imgval() == true) {
                    // after the validation form will submit..
                    $("#form").submit();
                    alert('validation successfull');
                } else {
                    alert('validation failed');
                }
            });
        });

        function namevalidation() {

            var cont_person = document.getElementById("fname").value;
            var nameFirstCharec = cont_person.charAt(0);
            var Alpha = /^[a-zA-Z\s.,]*$/;
            var AlphaNumeric = /^[0-9]+$/;

            if (cont_person == '') {
                $("#name_div").append("<span class='ValidationErrors' id='name_test'>  </span>");
                $("#name_test").html("No Null or numeric or spec Character*");
                $('#fname').addClass('ErrorField');
                return false;
            }
            else if (nameFirstCharec == ' ') {
                $("#name_div").append(" <span class='ValidationErrors' id='name_test'>  </span>");
                $("#name_test").html("No Null or numeric or spec Character*");
                $('#fname').addClass('ErrorField');
                return false;
            }
            else if (cont_person.length <= 2) {
                $("#name_div").append(" <span class='ValidationErrors' id='name_test'> </span>");
                $("#name_test").html("Name character can not be less than 2*");
                $('#fname').addClass('ErrorField');
                return false;
            }
            else if (cont_person.match(Alpha)) {
                $('span.ValidationErrors:contains("No Null or numeric or spec Character*")').remove();
                $('#fname').removeClass('ErrorField');
                return true;
            }
            else {
                $("#name_div").append(" <span class='ValidationErrors' id='name_test'>  </span>");
                $("#name_test").html("Null or No numeric or spec Character*");
                $('#fname').addClass('ErrorField');
                return false;
            }

        }
        function urlval() {

            var url = document.getElementById("url").value;
            var regexp = /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;

            if (url == '') {
                $('#url_test').append(" <span class='ValidationErrors' id='url_err'> </span>");
                $('#url').addClass('ErrorField');
                $("#url_err").html("Select a valid url*");
                return false;
            }
            else if (url.match(regexp)) {
                $('span.ValidationErrors:contains("Select a valid url*")').remove();
                $('#url_test').removeClass('ValidationErrors');
                $('#url').removeClass('ErrorField');
                return true;
            }

            else {
                $("#url_test").append(" <span class='ValidationErrors' id='url_err'>  </span>");
                $("#url_err").html("invalid url*");
                $('#url').addClass('ErrorField');
                return false;
            }

        }

        function teamval() {
            var team = document.getElementById("teamtype").value;
            // alert (team);
            if (team == "Please Select") {
                $('#team_test').append(" <span class='ValidationErrors' id='team_err'> </span>");
                $('#teamtype').addClass('ErrorField');
                $("#team_err").html("Select team type*");
                return false;
            }
            else {
                $('span.ValidationErrors:contains("Select team type*")').remove();
                $('#teamtype').removeClass('ErrorField');
                return true;
            }
        }

        function playersval() {
            var players = document.getElementById("players").value;
            if (players == '') {
                $('#player_test').append(" <span class='ValidationErrors' id='players_err'> </span>");
                $("#players_err").html("Provide players information*");
                $('#players').addClass('ErrorField');
                return false;
            }
            else if (players <= 3) {
                $("#player_test").append(" <span class='ValidationErrors' id='players_err'> </span>");
                $("#players_err").html("Plyers can not be less than 3*");
                $('#players').addClass('ErrorField');
                return false;
            }
            else if (players > 6) {
                $("#player_test").append(" <span class='ValidationErrors' id='players_err'> </span>");
                $("#players_err").html("Plyers can not be greater than 6*");
                $('#players').addClass('ErrorField');
                return false;
            }
            else {
                $('span.ValidationErrors:contains("Provide players information*")').remove();
                $('#player_test').removeClass('ValidationErrors');
                $('#players').removeClass('ErrorField');
                return true;
            }
        }

        function groundsval() {
            var rounds = document.getElementById("gamerounds").value;
            if (rounds == "Please Select") {
                $('#rounds_test').append(" <span class='ValidationErrors' id='rounds_err'> </span>");
                $('#gamerounds').addClass('ErrorField');
                $("#rounds_err").html("Select game round*");
                return false;
            }
            else {
                $('span.ValidationErrors:contains("Select game round*")').remove();
                $('#gamerounds').removeClass('ErrorField');
                return true;
            }
        }
        function imgval() {
            var fileName = document.getElementById('image').value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (fileName == '') {
                $('#img_test').append(" <span class='ValidationErrors' id='img_err'> </span>");
                $('#image').addClass('ErrorField');
                $("#img_err").html("Select a image*");
                return false;
            }
            else if ((extFile == "jpg" || extFile == "jpeg" || extFile == "png")) {
                $('#img_test').append(" <span class='ValidationErrors' id='img_err'> </span>");
                $('#image').addClass('ErrorField');
                $("#img_err").html("Select a image*");
                return true;
            }
            else {
                $('span.ValidationErrors:contains("Select a image*")').remove();
                $('#image').removeClass('ErrorField');
                return true;
            }

        }

    </script>
</body>

</html>