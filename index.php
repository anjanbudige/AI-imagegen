<!--
    © Author: Anjan Budige
      language: php
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Image Generator | Anjan Budige</title>
    <meta property="og:image" content="https://ai.m4uflix.xyz/image-upscale/image-upscale.jpg" />
<meta property="og:description" content=""Generate text to image with gerative ai." />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Solway' rel='stylesheet'>
    <link rel="stylesheet" href="style2.css">
    <style>
        body{
            font-family: solway;
        }
        figure {
            display: none;
            margin: 50px;
            top: 0; bottom: 0; left: 0; right: 0;
            width: 6.250em; height: 6.250em;
            animation: rotate 2.4s linear infinite;
        }

        .white {
            top: 0; bottom: 0; left: 0; right: 0;
            background: white;
            animation: flash 2.4s linear infinite;
            opacity: 0;
        }

        .dot {
            position: absolute;
            margin: auto;
            width: 2.4em; height: 2.4em;
            border-radius: 100%;
            transition: all 1s ease;
        }

        .dot:nth-child(2) { top: 0; bottom: 0; left: 0; background: #FF4444; animation: dotsY 2.4s linear infinite; }
        .dot:nth-child(3) { left: 0; right: 0; top: 0; background: #FFBB33; animation: dotsX 2.4s linear infinite; }
        .dot:nth-child(4) { top: 0; bottom: 0; right: 0; background: #99CC00; animation: dotsY 2.4s linear infinite; }
        .dot:nth-child(5) { left: 0; right: 0; bottom: 0; background: #33B5E5; animation: dotsX 2.4s linear infinite; }

        @keyframes rotate {
            0% { transform: rotate( 0 ); }
            10% { width: 6.250em; height: 6.250em; }
            66% { width: 2.4em; height: 2.4em; }
            100%{ transform: rotate(360deg); width: 6.250em; height: 6.250em; }
        }

        @keyframes dotsY {
            66% { opacity: .1; width: 2.4em; }
            77%{ opacity: 1; width: 0; }
        }

        @keyframes dotsX {
            66% { opacity: .1; height: 2.4em;}
            77%{ opacity: 1; height: 0; }
        }

        @keyframes flash {
            33% { opacity: 0; border-radius: 0%; }
            55%{ opacity: .6; border-radius: 100%; }
            66%{ opacity: 0; }
        }

        #box {
            width: 300px;
            height: 500px;
            border: 5px solid blue;
            border-radius: 5px;
            margin: 10px;
            display: none;
            padding: 10px;
        }

        #imageContainer img {
            max-width: 300px;
            max-height: 300px;
        }
        #img{
            display: none;
            border: 2px solid black;
            border-radius: 5px;
        }

        
    </style>
</head>
<body>
    <h1 style="text-align: center; font-size: 30px;">AI Image Generator &hearts;</h1>

    <script>
      function generateAndDisplayImage() {
    var promptValue = $("#prompt").val();
    var modelValue = $("#model").val();
    var aimodelValue = $("#aimodel").val();

    // Get the current path
       var currentPath = window.location.pathname.replace(/\//g, '');

    $('#box').show();
    $('figure').show();
    $('img').hide();

    document.getElementById('gen').innerHTML = "Image Generating";

    // AJAX call to generate job
    $.ajax({
        type: "POST",
        url: "generate_image.php",
        data: {
            prompt: promptValue,
            model: modelValue,
            aimodel: aimodelValue,
            currentPath: currentPath  // Include the current path in the data
        },
        dataType: "json",
        success: function(response) {
            checkJobStatus(response.job, promptValue, currentPath);
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
            $("#box").hide();
        }
    });
}

function checkJobStatus(job, promptValue, currentPath) {
    $.ajax({
        type: "POST",
        url: "check_job_status.php",
        data: {
            job: job,
            prompt: promptValue,
            currentPath: currentPath  // Include the current path in the data
        },
        dataType: "json",
        success: function(response) {
            if (response.imageUrl) {
                $("figure").hide();
                document.getElementById('gen').innerHTML = "Image Generated";
                document.getElementById('img').src = response.imageUrl;
                $('img').show();
            } else if (response.status === "failed") {
                $("figure").hide();
                $("#gen").hide();
                $("#box").html('<p>Image generation failed.</p>');
            } else {
                setTimeout(function() {
                    checkJobStatus(job, promptValue, currentPath);
                }, 1000);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
            $("#box").hide();
        }
    });
}
    </script>

    <!-- Form for user input -->

    <style>
        .container{
            margin-left: 10px;
            margin-right: 20px;
            width: 350px;
            min-height: 500px;
            background: #83a4e9;
            border: 10px solid #83a4e9;
            border-radius: 10px;
            line-height: 25px;
            text-align: center;
            padding: 5px;
        }
        button[type="submit"]{
            margin: 20px;
            width: 250px;
            height: 60px;
            background-color: yellow;
            border: 2px solid black;
            border-radius: 5px;
            font-size: 1.0rem;
            font-family: solway;
            font-weight: bold;
        }
        textarea{
            margin: 10px;
            width: 200px;
            height: 60px;
            background-color: white;
            border: 2px solid black;
            border-radius: 5px;
            font-size: 19px;
            font-weight: bold;
            color: blue;
        }
        .t3{
            font-size: 19px;
            font-weight: bold;
            margin: 2px;

        }
        .dev{
            margin: 0 auto;
            width: 250px;
            height: 60px;
            background-color: white;
            border: 2px solid black;
            border-radius: 5px;
            font-size: 19px;
            font-weight: bold;
        }
        .main{
            display: flex;
            flex-wrap: wrap;
            position: relative;
        }
        
select {
    width: 250px;
    height: 40px;
    margin: 10px;
    font-family: solway;
    background-color: white;
    border: 2px solid black;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    color: blue;
}


select::-ms-expand {
    display: none;
}

select option {
    padding: 10px;
    font-size: 14px;
    font-family: solway;
    background-color: white;
    color: black;
}

select:focus {
    outline: none;
    border-color: #3498db;
}

select:hover {
    border-color: #2980b9;
}


   .dbox{
  border-radius: 10px;
  background: #1feb26;
  width: 95%;
  text-align: center;
  height: 35px;
  position: relative;
  left: 50%;
  transform: translateX(-50%);
  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  padding: 17px;
}

    </style>
    <div class="main">
    <div class="container">
    <form id="imageForm" onsubmit="generateAndDisplayImage(); return false;">
        <p class="t3">Enter a prompt:</p>
        <textarea id="prompt" name="prompt" required></textarea>
        <br>
         <p class="t3">Select a Stablediffusion Model:<p>
                <select id="aimodel" name="aimodel">
                    <option value="dreamshaperXL10_alpha2.safetensors [c8afe2ef]">DreamshaperXL</option>
                    <option value="dynavisionXL_0411.safetensors [c39cc051]">DynavisionXL</option>
                    <option value="juggernautXL_v45.safetensors [e75f5471]">JuggernautXL</option>
                    <option value="realismEngineSDXL_v10.safetensors [af771c3f]">RealismEngineSDXL</option>
                    <option value="sd_xl_base_1.0.safetensors [be9edd61]">SDXL</option>
                    <option value="sd_xl_base_1.0_inpainting_0.1.safetensors [5679a81a]">SDXL inpainting</option>
                    <option value="turbovisionXL_v431.safetensors [78890989]">TurbovisionXL</option>
                </select>
                <br>
                
         <p class="t3">Select a Preset:<p>
                <select id="model" name="model">
                    <option value="3d-model">3d-model</option>
                    <option value="analog-film">Analog Film</option>
                    <option value="anime">Anime</option>
                    <option value="cinematic">Cinematic</option>
                    <option value="comic-book">Comic Book</option>
                    <option value="digital-art">Digital Art</option>
                    <option value="enhance">Enhance</option>
                    <option value="fantasy-art">Fantasy Art</option>
                    <option value="isometric">Isometric</option>
                    <option value="line-art">Line Art</option>
                    <option value="low-poly">Low Poly</option>
                    <option value="neon-punk">Neon Punk</option>
                    <option value="origami">Origami</option>
                    <option value="photographic">Photographic</option>
                    <option value="pixel-art">Pixel Art</option>
                    <option value="texture">Texture</option>
                    <option value="craft-clay">Craft Clay</option>
                </select>
                <br>
        <button type="submit">Generate Image</button>
        <br>
        <div class="dev"><p>Designed By Info Cruise</p></div>

    </form>

    </div>

    <div id="box">
        <p id="gen" style="text-align: center; margin: 5px;"></p>
        <figure>
            <div class="dot white"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </figure>
        <br>
        <img id="img" src="" alt="" width="300px" height="300px">
    </div>
    </div>
<br>
<div class="dbox">
        <b style="color: #09203F; font-size:19px" id="dev">Developed By Anjan Budige</b>
    </div>
</body>
</html>
