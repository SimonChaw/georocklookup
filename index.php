<?php
    $ip = $_SERVER['REMOTE_ADDR'];
    $location = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));   
?>
<html>
    <head>
        <title>Geo Lookup Rock</title>
        <link href='https://fonts.googleapis.com/css?family=Amatic+SC:400,700' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link type="text/css" rel="stylesheet" href="georock.css" />
    </head>
    <body>
        <header>
            <h1>Welcome to Geo Look Up Rock</h1>
        </header>
        <div class="main-content">
            <h3>Pick which of the two rocks remind you more of home. This information is then sent to a super computer to determine where you live based on which rock reminds you of your location.</h3>
            <img class="img-circle" id="rock" src="images/rock1.jpg" />
            <img class="img-circle" id="stone" src="images/stone1.jpg"/>
        </div> 
    </body>
    <footer>
        <p id="txtGuess">Go on... pick one!</p>
    </footer>
    <script type="text/javascript">
        //Actually... there is no super computer... this is a geo lookup test using a third party service phpinfo.io. This whole process is based on the information in your ip address.
        var country = "<?php echo $location->country ?>";
        var stateOrProvince = "<?php echo $location->region ?>";
        var city = "<?php echo $location->city ?>";
        var stage = 1;
        var rock = document.getElementById("rock");
        var stone =  document.getElementById("stone");
        var txtGuess = document.getElementById("txtGuess");
        
        rock.addEventListener("click", advance);
        stone.addEventListener("click", advance);
        
        function advance(e){
            if(stage == 1){
                setNewImages();
                txtGuess.innerHTML = "Judging by that rock, you probably live in..." + country;
            }else if(stage == 2){
                setNewImages();
                txtGuess.innerHTML = stateOrProvince + "," + country + " to be exact.";
            }else if(stage ==3 ){
                setNewImages();
                txtGuess.innerHTML = "Ok that's the rock that settled it. You are in " + city + ", " + stateOrProvince + ", " + country;
            }
            stage ++;
        }
        
        function setNewImages(){
            $(stone).fadeOut("slow");
            $(rock).fadeOut("slow");
            $(rock).promise().done(function(){
                if(stage < 4){
                    stone.src = "images/stone" + stage + ".jpg";
                    rock.src = "images/rock" + stage + ".jpg";
                    $(stone).fadeIn("slow");
                    $(rock).fadeIn("slow");
                }
            });
            if(stage == 3){
                $(txtGuess).delay(4000).fadeOut("slow");
                $(txtGuess).promise().done(function(){
                    txtGuess.innerHTML = "Actually... there is no super computer... this is a geo lookup test using a third party service: phpinfo.io. This whole process is based on the information in your ip address.";
                    $(txtGuess).fadeIn("slow");
                });
            }
        }
    </script>
</html>