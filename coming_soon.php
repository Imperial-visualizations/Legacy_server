<!doctype html>
<!-- **This line is extremely important, it tells the browser to use HTML5 instead of HTML 4.1**  -->
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Imperial Visualisations - Coming Soon</title>
    <link rel="icon" href="https://www.imperial.ac.uk/T4Assets/favicon-196x196.png" type="image/x-icon">
    <link rel="stylesheet" href="https://manglekuo.com/i-v/styles.css?v=1">
    <link rel="stylesheet" href="/assets/ivlogo.css">
    <style type="text/css">
        /* css here */
        body{
            display: block;
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            height: 100%; min-height: 100%; width: 100%; min-width: 100%;
            position: absolute; top: 0; right: 0; bottom: 0; left: 0;/* make it full-screen */  
            background: #003E74;
        }
        .section{
            display: block;
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            position: relative;
            background: #003E74;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            flex-direction:  column;

            background: #002147;
            background: linear-gradient(45deg, #33adff, #99008a);
        }
        .section>div{
            opacity: 0.85;
        }
        .section>div:nth-child(1){
            opacity: 0.2;
            position: absolute;
            font-size: 1700px;
            transform: translate(60px,90px);/*
            text-shadow: 0 1px 0 #c9c9c9,
                   4px 10px 8px rgba(0,0,0,.2),
                   4px 10px 10px rgba(0,0,0,.2),
                   4px 10px 20px rgba(0,0,0,.15);*/
  
        }
        .section>div:nth-child(2){
            opacity: 0.9;
            font-size: 200px;
            text-align: center;
            display: block;           
            transform: translateY(-60px);  
            transition: transform 300ms ease-out, text-shadow 300ms ease-out;
            text-shadow: 0 1px 0 #c9c9c9,
                    0 2px 0 #c9c9c9,
                    0 3px 0 #c9c9c9,
                   4px 30px 10px rgba(0,0,0,.2),
                   4px 30px 20px rgba(0,0,0,.15);
        }
        .section>div:nth-child(2):hover{
            opacity: 0.9;
            font-size: 200px;
            text-align: center;
            display: block;           
            transform: translateY(-90px);   
            text-shadow: 0 1px 0 #c9c9c9,
                    0 2px 0 #c9c9c9,
                    0 3px 0 #c9c9c9,
                   4px 60px 10px rgba(0,0,0,.2),
                   4px 60px 20px rgba(0,0,0,.15);
        }        
        .section>div:nth-child(3){
            font-size: 40px;
            text-align: center;
            display: block;           
            transform: translateY(-100px);   
            text-shadow: 0 1px 0 #c9c9c9,
                    0 1.5px 0 #c9c9c9,
                   4px 10px 8px rgba(0,0,0,.2),
                   4px 10px 10px rgba(0,0,0,.2),
                   4px 10px 20px rgba(0,0,0,.15);
        }
</style>
</head>
<body class="no-nav">
<div class="section">
        <div><span class="icon-iv-logo-v4-small"></span></div>
        <div><span class="icon-iv-logo-v4"></span></div>
        <div>Coming soon!!!!!<div>
</div>
</body>
</html>
