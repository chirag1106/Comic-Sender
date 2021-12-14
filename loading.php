<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .loader{
    height: 100vh;
    width: 100vw;
    overflow: hidden;
    background-color: #16191e;
    position: absolute;
}
.loader>div{
    height: 100px;
    width: 100px;
    border: 15px solid #45474b;
    border-top-color: #2a88e6;
    position: absolute;
    margin: auto;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    border-radius: 50%;
    animation: spin 1.5s infinite linear;
}
@keyframes spin{
    100%{
        transform: rotate(360deg);
    }
}
    </style>
</head>
<body>
    <div class="loader">
        <div></div>
    </div>

    <script>
        $(window).on('load',function(){
            $(".loader").fadeOut(1000);
            
        });
    </script>
</body>
</html>