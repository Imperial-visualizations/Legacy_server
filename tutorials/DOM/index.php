 
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Imperial Visualisation</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel = "icon" href = "https://www.imperial.ac.uk/T4Assets/favicon-196x196.png" type="image/x-icon">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="https://manglekuo.com/i-v/styles.css?v=2">
  <style type="text/css">
    .example-grid .column, .example-grid .columns {
      background: #EEE;
      text-align: center;
      border-radius: 4px;
      font-size: 1rem;
      text-transform: uppercase;
      height: 30px;
      line-height: 30px;
      margin-bottom: .75rem;
      font-weight: 600;
      letter-spacing: .1rem;
    }

    .playStopButton{
      width: 100px;
      height: 40px;
      box-sizing: border-box;
      color: #fff;
      background-color: #C81E78;
      text-align: center;

      line-height: 36px;
      border-bottom: 4px solid #9F004E;
      text-shadow: 0px 1px 0px #9F004E;
      transition: all 100ms linear; /*This is the magic bit that makes the button
                                      get "pressed" smoothly. 
                                      It means "give all properties of matching elements
                                      a transition, with 100ms duration, and let the
                                      f(t) function be linear."*/
    }
    .playStopButton.pressed{ /* Select elements that has both 
                                "playStopButton" and "pressed" class
                                at the same time*/
      border-top: 4px solid #9F004E;
      border-bottom: none;
    }

    .playStopButtonV1{ /* Use css to chose the element(s) with class playStopButton
                        "." for class, "#" for id, nothing for tag,
                        e.g. <button id="openMenu" class="openButton">Open Menu</button>
                        can be selected by using button{} or #openMenu{} or .openButton{} 
                        inside {} are the styles you want for those elements which matches the
                        selector.
                        The later ones will overwrites the ones before. */
      width: 100px;
      height: 40px;
      background-color: #C81E78;
      color: #ffffff; /* Text colour */
      text-align: center;
    }

    .playStopButtonV2{
      width: 100px;
      height: 40px;
      background-color: #C81E78;
      color: #ffffff; 
      text-align: center;

      box-sizing: border-box;
      line-height: 36px;
      border-bottom: 4px solid #9F004E;
      text-shadow: 0px 1px 0px #9F004E;
    }
    .playStopButtonV2:active{ /* The ":active" selector actives when the element 
                                  is being clicked.
                                */
      border-top: 4px solid #9F004E;
      border-bottom: none;
    }

    .playStopButtonV3{
      width: 100px;
      height: 40px;
      box-sizing: border-box;
      color: #fff;
      background-color: #C81E78;
      text-align: center;

      line-height: 36px;
      border-bottom: 4px solid #9F004E;
      text-shadow: 0px 1px 0px #9F004E;
      transition: all 100ms linear; /*This is the magic bit that makes the button
                                      get "pressed" smoothly. 
                                      It means "give all properties of matching elements
                                      a transition, with 100ms duration, and let the
                                      f(t) function be linear."*/
    }
    .playStopButtonV3.pressed{ /* Select elements that has both 
                                "playStopButton" and "pressed" class
                                at the same time*/
      border-top: 4px solid #9F004E;
      border-bottom: none;
    }


    .colourTiles, .tileTitle, .tileSubtitle, .tileValue{
      -moz-user-select: -moz-text;
      -khtml-user-select: text;
      -webkit-user-select: text;
      -ms-user-select: text;
      user-select: text;
      cursor: pointer;
    }
    .colourTiles{
      margin-bottom: 50px;
      background-color: #aaa;
      box-sizing: border-box;
      padding: 10px;
      display: flex;
      flex-wrap: wrap;
      transition: box-shadow 160ms cubic-bezier(.81,.82,.37,1);
    }
    .colourTiles:hover{
      box-shadow:  0 1px 5px rgba(0,0,0,.1),
                   0 5px 10px rgba(0,0,0,.25),
                   0 10px 10px rgba(0,0,0,.2);
    }
    .colourTiles:active{
      box-shadow:  0 0px 0px #fff;
    }
    .tileTitle{
      flex-basis: 100%;
      font-size: 1em;
      font-weight: 800;  
      margin-bottom: 0.618em;
    }
    .tileSubtitle,.tileValue{
      font-size: 0.66em; 
    }
    .tileSubtitle{flex-basis: 33%;}
    .tileValue{flex-basis: 67%;}

    .copied{
      position: absolute;
      display: inline-block;
      left: 0;
      top: 0;
      height: 30px;
      line-height: 30px;
      background-color: #fff;
      color: #000;
      font-size: 12px;
      box-sizing: border-box;
      padding: 0 10px;
      font-style: italic;
      font-family: Georgia, Utopia, 'Times New Roman', Times, serif;
      display: none;
    }

    img{
      width: 100%;
    }
  </style>

  <!-- async javascripts
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({
      tex2jax: {
          inlineMath: [ ["\[","\]"] ],
          displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
          processEscapes: false,
      }
  });
  </script>
<script type="text/javascript" async
  src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-MML-AM_CHTML">
</script>


</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
      <h1 class="title">HTML DOM: CSS, Javascript & jQuery</h1>
        <div class="row">
          <div class="twelve columns">
            <ul class="dropdown">
                <li>
                    <span id="Menu">List of Contents</span>
                    <ul id="MenuItemContainer">
                    </ul>
                </li>
            </ul>
          </div>
        </div>
          <h2 id="getting-started">Getting Started</h2>
        <div class="row">
          <div class="seven columns">
<ol>
<li><p>Right click -> Save As <a href="./index.html">THIS FILE</a> as <em>index.html</em>.</p>
</li>
<li><p>Open <em>index.html</em> with PyCharm or whatever code-editor you like.</p>
</li>
<li><p>If you didn't do right click save as but have your <em>index.html</em> from the HTML tutorial instead, you might need to add one extra line:</p>
<pre><code> &lt;script src=&quot;https://code.jquery.com/jquery-3.2.1.min.js&quot;&gt;&lt;/script&gt;
</code></pre><p> before the <code>&lt;script src=&quot;scripts/program.js&quot;&gt;&lt;/script&gt;</code>.</p>
</li>
<li><p>Start adding Javascript/JQuery codes between the <code>&lt;script&gt;// javascript or jQuery here.&lt;/script&gt;</code> tags.</p>
</li>
</ol>
          </div>
          <div class="five columns">
<pre>
<code>Recommonded folder structure for your <em>index.html</em>:

+ DOM/
| + assets/
| + scripts/
| |- program.js
| + styles/
|- index.html
</code>
</pre>
          </div>
        </div>
        <div class="row">
          <div class="twelve columns">
<p>5. This is what your <em>index.html</em> should look like right now:</p>
<pre><code>&lt;!doctype html&gt;
&lt;!-- **This line is extremely important, it tells the browser to use HTML5 instead of HTML 4.1**  --&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;meta charset=&quot;utf-8&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no&quot;&gt;
    &lt;title&gt;Imperial Visualisations&lt;/title&gt;
    &lt;link rel=&quot;icon&quot; href=&quot;https://www.imperial.ac.uk/T4Assets/favicon-196x196.png&quot; type=&quot;image/x-icon&quot;&gt;
    &lt;link rel=&quot;stylesheet&quot; href=&quot;https://manglekuo.com/i-v/styles.css?v=1&quot;&gt;
    &lt;style type=&quot;text/css&quot;&gt;
        /* css here */
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div class=&quot;container&quot;&gt;
        &lt;h1&gt;DOM examples&lt;/h1&gt;
        &lt;div class=&quot;row&quot;&gt;
            &lt;div class=&quot;eight columns&quot;&gt;
                &lt;p&gt;I could be your graph&lt;/p&gt;
            &lt;/div&gt;
            &lt;div class=&quot;four columns&quot;&gt;
                I could be your controllers
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;br&gt;&lt;br&gt;&lt;br&gt;
    &lt;script src=&quot;https://code.jquery.com/jquery-3.2.1.min.js&quot;&gt;&lt;/script&gt;
    &lt;script src=&quot;scripts/program.js&quot;&gt;&lt;/script&gt;&lt;!-- You can iether put your code 
                                                    inside this file ( which you&#39;ll 
                                                    have to create yourself) --&gt;
    &lt;script&gt;
        // Or put your javascript/jQuery code here.
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
</code></pre>
          </div>
        </div>
        <h2 id="colour">Colour</h2>
        <div class="row">
          <div class="six columns">
        <p>The following colours are colours from the <a href="https://www.imperial.ac.uk/media/imperial-college/staff/brand-and-style-guide/public/Branding-Guidelines-2016.pdf">IMPERIAL COLLEGE LONDON Visual identity guidelines</a>, please read through it before start using these colours. If you&#39;re not confident in choosing colour, please stick with the default colour that plotly has. However, when making customised UI instead of using &#39;red&#39; which usually means #FF0000, please use one of the options from below. </p>
<p>Most of the time you&#39;ll only need to work with HEX, which you&#39;ll see as #FFFFFF or 0xFFFFFF, rarely you&#39;ll need to work with RGB (rgb(255,255,255)) or RGBa (rgba(255,255,255,1)), the last one being opacity or alpha value, a measure of how not-transparent something is). CMYK stands for cyan, magenta, yellow, and key (black), which is used in printing, and PMS is the Pantone Matching System, which is used for cross-platform colour matching and referencing colour for paint or materials.</p>
<p>On the right you can see what the the following colour plattes looks like for two type of colour blinded people, please do take them into account when choosing colours for your user interface or graphs. As many as 8 % of men and 0.5 % of women with Northern European ancestry have the common form of red-green color blindness.[^1]</p>
<p>Avoid using colours that are similar in the colour blinded view in both your UIs and your graphs, as colourblinded people won&#39;t be able to tell them apart.</p>
<p>[^1]: <a href="https://nei.nih.gov/health/color_blindness/facts_about">&quot;Facts About Color Blindness&quot;</a>. NEI. February 2015. Retrieved 31 Aug 2017</p>
          </div>
          <div class="six columns">
             <ul class="tab-nav">
                <li>
                  <a class="button active" href="#normal">Normal</a>
                </li>
                <li>
                  <a class="button" href="#protanopia">Protanopia</a>
                </li>
                <li>
                  <a class="button" href="#deuteranopia">Deuteranopia</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="normal">
                  <img src="./assets/ColourPalette.png" title="Normal"/>
                </div>
                <div class="tab-pane" id="protanopia">
                  <img src="./assets/ColourPaletteProtanopia.png" title="Protanopia Colour Blind"/>
                </div>
                <div class="tab-pane" id="deuteranopia">
                  <img src="./assets/ColourPaletteDeuteranopia.png" title="Deuteranopia Colour Blind"/>
                </div>
              </div> 
          </div>
        </div>
        <div class="row">
          <div class="twelve columns">
            <p>Click the tiles to copy the colour in <select class="" id="colourCopyingOptions">
                  <option value="color">#FFFFFF</option>
                  <option value="colorWithoutHashTag">FFFFFF</option>
                  <option value="rgb">rgb(255,255,255)</option>
                  <option value="cmyk">cmyk(100,100,100,100)</option>
                  <option value="pms">Pantone</option>
                </select> formats.</p>
          </div>
        </div>
        <div class="row">
          <div class="six columns colourTiles" data-color="#002147" data-rgb="rgb(0,33,71)" data-cmyk="cmyk(100,55,0,85)" data-pms="539"><span class="tileTitle">Navy</span></div>

          <div class="six columns colourTiles" data-color="#003E74" data-rgb="rgb(0,62,116)" data-cmyk="cmyk(100,61,0,45)" data-pms="541"><span class="tileTitle">Imperial Blue</span></div>

        </div>
        <div class="row">
          <div class="two columns colourTiles" data-color="#EBEEEE" data-rgb="rgb(235,238,238)" data-cmyk="cmyk(0,0,0,15)" data-pms="COOL GREY 2"><span class="tileTitle">Light Grey</span></div>

          <div class="two columns colourTiles" data-color="#9D9D9D" data-rgb="rgb(157,157,157)" data-cmyk="cmyk(10,10,10,40)" data-pms="COOL GREY 7"><span class="tileTitle">Cool Grey</span></div>

          <div class="two columns colourTiles" data-color="#D4EFFC" data-rgb="rgb(212,239,252)" data-cmyk="cmyk(15,0,0,0)" data-pms="642"><span class="tileTitle">Light Blue</span></div>

          <div class="two columns colourTiles" data-color="#006EAF" data-rgb="rgb(0,110,175)" data-cmyk="cmyk(100,70,0,0)" data-pms="293"><span class="tileTitle">Blue</span></div>


          <div class="two columns colourTiles" data-color="#0091D4" data-rgb="rgb(0,133,202)" data-cmyk="cmyk(100,8,0,5)" data-pms="PROCESS BLUE"><span class="tileTitle">Process Blue</span></div>

          <div class="two columns colourTiles" data-color="#00ACD7" data-rgb="rgb(12,161,205)" data-cmyk="cmyk(75,0,0,0)" data-pms="306"><span class="tileTitle">Pool Blue</span></div>
        </div>
        <div class="row">
          <div class="two columns colourTiles" data-color="#0F8291" data-rgb="rgb(15,130,145)" data-cmyk="cmyk(100,0,25,50)" data-pms="3155"><span class="tileTitle">Dark Teal</span></div>

          <div class="two columns colourTiles" data-color="#009CBC" data-rgb="rgb(0,142,170)" data-cmyk="cmyk(100,0,25,0)" data-pms="3135"><span class="tileTitle">Teal</span></div>

          <div class="two columns colourTiles" data-color="#379F9F" data-rgb="rgb(55,159,159)" data-cmyk="cmyk(75,0,25,0)" data-pms="3115"><span class="tileTitle">Seaglass</span></div>

          <div class="two columns colourTiles" data-color="#02893B" data-rgb="rgb(2,137,59)" data-cmyk="cmyk(100,0,100,15)" data-pms="348"><span class="tileTitle">Dark Green</span></div>
          
          <div class="two columns colourTiles" data-color="#66A40A" data-rgb="rgb(102,164,10)" data-cmyk="cmyk(70,0,100,0)" data-pms="368"><span class="tileTitle">Kermit Green</span></div>
          
          <div class="two columns colourTiles" data-color="#BBCE00" data-rgb="rgb(196,214,0)" data-cmyk="cmyk(35,0,100,0)" data-pms="382"><span class="tileTitle">Lime</span></div>

        </div>
        <div class="row">
          <div class="two columns colourTiles" data-color="#D24000" data-rgb="rgb(210,64,0)" data-cmyk="cmyk(0,76,100,0)" data-pms="166"><span class="tileTitle">Orange</span></div>

          <div class="two columns colourTiles" data-color="#EC7300" data-rgb="rgb(236,115,0)" data-cmyk="cmyk(0,45,100,0)" data-pms="151"><span class="tileTitle">Tangerine</span></div>

          <div class="two columns colourTiles" data-color="#FFDD00" data-rgb="rgb(255,216,1)" data-cmyk="cmyk(0,10,100,0)" data-pms="109"><span class="tileTitle">Lemon Yellow</span></div>

          <div class="two columns colourTiles" data-color="#A51900" data-rgb="rgb(165,25,0)" data-cmyk="cmyk(20,100,100,20)" data-pms="207"><span class="tileTitle">Brick</span></div>
          
          <div class="two columns colourTiles" data-color="#DD2501" data-rgb="rgb(221,37,1)" data-cmyk="cmyk(0,100,100,0)" data-pms="WARM RED"><span class="tileTitle">Red</span></div>
          
          <div class="two columns colourTiles" data-color="#E40043" data-rgb="rgb(213,0,50)" data-cmyk="cmyk(0,100,62,0)" data-pms="199"><span class="tileTitle">Cherry</span></div>

        </div>
        <div class="row">
          <div class="two columns colourTiles" data-color="#9F004E" data-rgb="rgb(145,0,72)" data-cmyk="cmyk(0,100,16,40)" data-pms="221"><span class="tileTitle">Raspberry</span></div>

          <div class="two columns colourTiles" data-color="#C81E78" data-rgb="rgb(200,30,120)" data-cmyk="cmyk(0,100,9,4)" data-pms="RUBINE RED"><span class="tileTitle">Magenta Pink</span></div>

          <div class="two columns colourTiles" data-color="#751E66" data-rgb="rgb(119,37,131)" data-cmyk="cmyk(60,100,20,15)" data-pms="2612"><span class="tileTitle">Iris</span></div>

          <div class="two columns colourTiles" data-color="#960078" data-rgb="rgb(150,0,120)" data-cmyk="cmyk(34,100,0,0)" data-pms="2405"><span class="tileTitle">Violet</span></div>
          
          <div class="two columns colourTiles" data-color="#321E6D" data-rgb="rgb(50,30,109)" data-cmyk="cmyk(100,100,0,3)" data-pms="2105"><span class="tileTitle">Plum</span></div>
          
          <div class="two columns colourTiles" data-color="#653098" data-rgb="rgb(101,48,152)" data-cmyk="cmyk(88,86,0,0)" data-pms="2098"><span class="tileTitle">Purple</span></div>

        </div>
        <div class="row">
          <div class="twelve columns">
            <h2 id="html-dom-document-object-model">HTML DOM (Document Object Model)</h2>
<p>It just means you can access the properties of HTML tags (or elements) by using dot notation, like you did for object/class in Python. For example put <code>document.body.background = &quot;#ff0000&quot;;</code> inside your Javascript codes (where the <code>&lt;script&gt;// javascript or jQuery here.&lt;/script&gt;</code> is) would allows you to change the background colour of the page to red. The # thing is the common way to represent colour in HTML. #FF0000 = full red, #00FF00 = full green, #0000FF = full blue, #000000 = black, #FFFFFF = white. You use two digits of hexadecimal number (0123456789abcdef instead of 0123456789) to represent the amount of each colour you want. So #FFFF00 would be full red + full green = full yellow.</p>
<p>
  See the <a href="#colour">Colour</a> section for more about colours.
</p>
<p>As you have seen, often the property of the HTML element you&#39;ll need to change is a CSS style, which is why we are talking about them all at the same time in this tutorial.</p>
<p>You write HTML tags to represent the structure of your website, write Javascript/jQuery code to do dynamic stuff, and write css to style them.</p>
<h3 id="sync-or-async">Sync or Async?</h3>
<p>Javascript is a weird language. Most programming language can only load/execute from top to bottom, this is called "synchronous", or "Sync" for short. In Javascript this means you import your js file at the bottom of your html file, right before the <code>&lt;/body&gt;</code>tags. By doing so, it will make sure the Javascript code runs after all the HTML DOMs have been created, which in most cases is what you want, because only after the DOMs are created they can be manipulated. It also makes the page appeal to load faster because the loading of the DOMs are what the user can see.</p>
<p>When you put your js code in the <code>&lt;head&gt;</code> tags, it might execute asynchronously instead, or "Async" for short. This means the browser will try load/execute your code at the same time when it's creating all the DOMs. This is strongly not recommended so unless you know clearly what you're doing, always stick with "Sync".</p>
<p>The best practice is to always put your code inside a 
<pre><code>$(document).ready(function(){
    //your jQuery/javascript code here
});
</code></pre>
so that it always runs after all the DOMs are created.</p>
<h2 id="simple-button-example">Simple Button Example</h2>
<h3 id="final-result">Final result</h3>
<p>Let's try to create something which look like this (sound effect not included in this tutorial): </p>
          <div class="playStopButton">▶︎ PLAY</div>
<br>
<h3 id="1-create-html">1. Create HTML</h3>
<p>Let's first start by creating an HTML tag:</p>
<p><code>&lt;div class=&quot;playStopButton&quot;&gt;▶︎ PLAY&lt;/div&gt;</code></p>
<p>Put it somewhere nice, for example in your <em>four columns</em>. Now you should only see a line of text:</p>
<div style="">▶︎ PLAY</div><br>
<h3 id="2-add-css">2. Add CSS</h3>
<p>Now let's start adding some styles. Put the following code inside your <code>&lt;style type=&quot;text/css&quot;&gt;&lt;/style&gt;</code></p>
<pre><code>.playStopButton{ /* Use css to chose the element(s) with class playStopButton
                    &quot;.&quot; for class, &quot;#&quot; for id, nothing for tag,
                    e.g. &lt;button id=&quot;openMenu&quot; class=&quot;openButton&quot;&gt;Open Menu&lt;/button&gt;
                    can be selected by using button{} or #openMenu{} or .openButton{} 
                    inside {} are the styles you want for those elements which matches the
                    selector.
                    The later ones will overwrites the ones before. */
  width: 100px;
  height: 40px;
  background-color: #C81E78;
  color: #ffffff; /* Text colour */
  text-align: center;
}
</code></pre>
<p>Now if you run your HTML file (double click it to open with a browser OR run it on a localhost server (recommended)), you should see something that look like this:</p>
<div class="playStopButtonV1">▶︎ PLAY</div><br>
<p>Now let's add in more css to make it nicer. Expand the css code for your .playStopButton:</p>
<pre><code>.playStopButton{
  width: 100px;
  height: 40px;
  background-color: #C81E78;
  color: #ffffff; 
  text-align: center;

  box-sizing: border-box;
  line-height: 36px;
  border-bottom: 4px solid #9F004E;
  text-shadow: 0px 1px 0px #9F004E;
}
.playStopButton:active{ /* The &quot;:active&quot; selector actives when the element 
                              is being clicked.
                            */
  border-top: 4px solid #9F004E;
  border-bottom: none;
}
</code></pre>
<div class="playStopButtonV2">▶︎ PLAY</div>
(Try click it)
<br><br>
<p>It might look a bit confusing now because some of the stuff we&#39;ve added might not make sense, or you might think they are badly named. This is highly due to the legacy from the first version of HTML we had, which was created at CERN. Luckily, after more then two decades of development, HTML, CSS and Javascript, the three cornerstones of the web world are probably some of the most well documented programming languages in the world. </p>
<p>If you have any problems with CSS or Javascript or jQuery, just Google it. Most likely someone else have had the same problems. For now, read through <a href="https://www.w3schools.com/cssref/css_selectors.asp">w3schools css-selectors</a>, <a href="https://www.w3schools.com/cssref/css3_pr_box-sizing.asp">w3schools box-sizing</a>, <a href="https://stackoverflow.com/questions/8865458/how-do-i-vertically-center-text-with-css">stackoverflow line-height</a> to understand what css we&#39;ve used here to achieved the style we wanted. Edit the css, try changing the css to understand what each one of them do.</p>
<h3 id="3-write-javascript-jquery">3. Write Javascript/jQuery</h3>
<p>Hopefully you should have a rough understanding of the css by now, it&#39;s nice that the css have the selector that actives when the mouse is pressed down, but if we want the &quot;pressed&quot; status to stay, as well as changing the text inside the button, we will have to use Javascript.</p>
<p>The best way to achieve any sort of changing in style with Javascript, is to write a class for that style, then use Javascript to change the class of that element.</p>
<p>First, replace the :active css selector with .pressed :</p>
<pre><code>.playStopButton{
  width: 100px;
  height: 40px;
  box-sizing: border-box;
  color: #fff;
  background-color: #C81E78;
  text-align: center;

  line-height: 36px;
  border-bottom: 4px solid #9F004E;
  text-shadow: 0px 1px 0px #9F004E;
  transition: all 100ms linear; /*This is the magic bit that makes the button
                                  get &quot;pressed&quot; smoothly. 
                                  It means &quot;give all properties of matching elements
                                  a transition, with 100ms duration, and let the
                                  f(t) function be linear.&quot;*/
}
.playStopButton.pressed{ /* Select elements that has both 
                            "playStopButton" and "pressed" class
                            at the same time*/
  border-top: 4px solid #9F004E;
  border-bottom: none;
}
</code></pre>
<p>Second, write Javascript/jQuery code inside your <code>&lt;script&gt;// javascript or jQuery here.&lt;/script&gt;</code> to add/remove class when clicked:</p>
<pre><code>$(&quot;.playStopButton&quot;).on(&#39;click&#39;,function(){
  $(this).toggleClass(&quot;pressed&quot;);
});
</code></pre><p>Here, we are using jQuery, which is a library of Javascript that provides a simpler way to access DOM. It allows you to write less code to achieve the same thing, as well as giving you a lot of useful functions to access the DOM.</p>
<p>If you write the same code in Javascript it would look like this:</p>
<pre><code>document.getElementsByClassName(&quot;playStopButton&quot;)[0].onclick = function(){
  if(document.getElementsByClassName(&quot;playStopButton&quot;)[0].className == &quot;playStopButton pressed&quot;){
    document.getElementsByClassName(&quot;playStopButton&quot;)[0].className = &quot;playStopButton&quot;;
  }else{
    document.getElementsByClassName(&quot;playStopButton&quot;)[0].className = &quot;playStopButton pressed&quot;;
  }
};
</code></pre><p>which is bulky so <strong>just use jQuery</strong>!!!</p>
<p>Now, let&#39;s add the text changing bit:</p>
<pre><code>$(&quot;.playStopButton&quot;).on(&#39;click&#39;,function(){
  $(this).toggleClass(&quot;pressed&quot;);
  if($(this).hasClass(&quot;pressed&quot;)){
    //Pressed ▶︎︎ PLAY
    $(this).text(&quot;◼︎︎ STOP&quot;);
  }else{
    //Pressed ◼︎︎ STOP
    $(this).text(&quot;▶︎︎ PLAY&quot;);
  }
});
</code></pre>
<h3 id="4-ta-dah">4. Ta-dah</h3>
<div class="playStopButtonV3">▶︎ PLAY</div>
(Sorry you don't get the sound effect)
<br><br><br>
          </div>
        </div>
        <h2 id="css-basics">CSS Basics</h2>
        <div class="row">
          <div class="twelve columns">
<p><strong> Go to <a href="https://www.w3schools.com/css/">https://www.w3schools.com/css/</a></strong></p>
          </div>
        </div>
        <h2 id="javascript-basics">Javascript Basics</h2>
        <div class="row">
          <div class="twelve columns">
<p><strong> This section tells you what you <em>need</em> to know when coding with Javascript </strong></p>
<h3 id="keep-in-mind-">Keep in mind..</h3>
<ol>
<li>Don&#39;t forget to add semi-colon(;) at the end of each statement.</li>
<li>parseFloat() before summation. (Javascript uses &quot;+&quot; for both string joining and number summation)</li>
<li>Use || for &quot;or&quot;, &amp;&amp; for &quot;and&quot; in if statement</li>
<li>It&#39;s a dynamic typed programming language. (See below)</li>
<li>Don&#39;t use ** or ^ for power</li>
<li>Variables outside any functions are global by default, and can be accessed within any defined functions.</li>
</ol>
<h3 id="1-it-uses-instead-of-whitespaces-indent-to-indicate-block-of-code-">1. It uses &quot;{}&quot; instead of whitespaces/indent to indicate block of code.</h3>
<p>If statement in Python:</p>
<pre><code>    if variableA == variableB:
        return &quot;Yes they are equal&quot;
</code></pre><p>If statement in Javascript:</p>
<pre><code>    if(variableA == variableB){
        return &quot;Yes they are equal&quot;;
    }
</code></pre><p>In Javascript, the whitespaces and new lines are not that important. They are more for human to read instead of your browser. It&#39;s totally fine to have your entire js file written in one line. When importing packages from online, often you&#39;ll see two downloading options, &quot;xxxx.js&quot; and &quot;xxxx.min.js&quot;, the second one would be the squashed version of the first file with just one single line of code, so the file size is minimized.</p>
<p>For the same if statement shown above, you can just do</p>
<pre><code>if(variableA==variableB){return &quot;Yes they are equal&quot;;}
</code></pre><h3 id="2-it-s-object-oriented-">2. It&#39;s object oriented.</h3>
<p>In Javsacript, everything can be treated as an object (things with dot notation), i.e.:</p>
<p>&#39;&gt;&#39; and &#39;&lt;&#39; means the input and output in Javascript console, 
which you can access in your browser by 
doing <em>right click</em> -&gt; <em>Inspect</em> -&gt; <em>Console</em></p>
<pre><code>
&gt; var str = &quot;hello&quot;;
&gt; str.length 
&lt; 5

function add(a,b){
    return a+b;
}
//is the same as
var add = function(a,b){
    return a+b;
};

//defining a class:
var Shape = function(area,colour){
    this.area = area;
    this.colour = colour;
    this.turnBlack = function(){
        this.colour = &quot;#000000&quot;;
    };
}

//inheriting a class:
var Square = function(sideLength,colour){
    Shape.call(this,Math.pow(sideLength,2),colour);
    this.getDiagonal = function(){
        return Math.sqrt(Math.pow(sideLength,2)+Math.pow(sideLength,2));
    };
}

//defining a object with properties:
var myObj = {
    index: 12,
    id: &quot;aj49adsf&quot;,
    getID: function(){
        return this.id;
    }
};

&gt; myObj.index
&lt; 12
&gt; myObj.getID()
&gt; &quot;aj49adsf&quot;
</code></pre><h3 id="3-it-doesn-t-have-or-as-power">3. It doesn&#39;t have ** or ^ as power</h3>
<p>Well, technically it does in newest version of Javascript, which is supported by the newest version of Chrome, FireFox, Safari, but for supportability it&#39;s always better to just use <code>Math.</code> instead.</p>
<pre><code>// It looks like Math is a library but it&#39;s 
// build in in Javascript, and you don&#39;t need 
// to import anything.

&gt; Math.pow(2,3)
&lt; 8

&gt; Math.sqrt(16)
&lt; 4

&gt; Math.round(14.353)
&lt; 14

&gt; Math.PI
&lt; 3.141592653589793

&gt; Math.E
&lt; 2.718281828459045

&gt; Math.sin(Math.PI)
&lt; 1.2246467991473532e-16
// Which is basically 0.
</code></pre><p>Javascript has <code>Math.atan(y/x)</code> and <code>Math.atan2(y,x)</code>, which are different (Google if you&#39;re curious). Use atan2.</p>
<pre><code>// Math.atan2(y,x):The arctangent of the quotient of the given arguments.
&gt; Math.atan2(1,0)
&lt; 1.5707963267948966
&gt; Math.atan2(0,1)
&lt; 0
&gt; Math.atan2(0,-1)
&lt; 3.141592653589793
&gt; Math.atan2(-1,0)
&lt; -1.5707963267948966
</code></pre><p>For random numbers, use <code>Math.random()</code> to generate a random number between 0 (inclusive) and 1 (exclusive), then scale the number to the range you want to.</p>
<pre><code>&gt; Math.random()
&lt; 0.09621543534727861
</code></pre><h3 id="4-it-s-dynamic-typed">4. It&#39;s dynamic typed</h3>
<p>When doing calculation or comparison, Javascript will automatic convert the type of the object if they&#39;re convertible. See the following examples.</p>
<pre><code>&gt; &quot;14&quot; == 14
&lt; true

&gt; &quot;14&quot; === 14
&lt; false

&gt; 1 == true
&lt; true

&gt; 0 == false
&lt; true

&gt; 0 === false
&lt; false

&gt; 5 == true
&lt; false

&gt; &quot;hello&quot; == true
&lt; false

&gt; &quot;&quot; == false
&lt; true

&gt; true == undefined
&lt; false

&gt; !undefined
&lt; true

&gt; &quot;hello&quot; + 14.5
&lt; &quot;hello14.5&quot;

&gt; &quot;4&quot; + 5
&lt; &quot;45&quot;

&gt; 15-&quot;4&quot;
&lt; 11

&gt; 14.5 + 9
&lt; 23.5

&gt; 0xff + 0
&lt; 255
</code></pre>
          </div>
        </div>
        <h2 id="jquery-basics">jQuery basics</h2>
        <div class="row">
          <div class="twelve columns">
<h3 id="console-your-best-friend-for-debugging">Console, your best friend for debugging</h3>
<p><code>right-click on your webpage -&gt; &quot;inspect&quot; -&gt; &quot;console&quot;</code>
This will take you to the javascript console. Try typing in <code>console.log(&#39;Hello World&#39;);</code>. Use this to help you debug your bugzzz.</p>
<h3 id="what-you-can-do-to-an-element">What you can do to an element</h3>
<p>1. for the element <code>&lt;div id=&quot;yellowButton&quot; data-message=&quot;hahaha&quot;&gt;I am a yellow button&lt;/div&gt;</code>, you can do:</p>
<pre><code>$(&quot;#yellowButton&quot;).text();
// returns &quot;I am a yellow button&quot;

$(&quot;#yellowButton&quot;).text(&quot;&lt;em&gt;I am a blue button&lt;/em&gt;&quot;);
// set the inner html to &quot;&amp;lt;em&amp;gt;I am a blue button&amp;lt;/em&amp;gt;&quot;

$(&quot;#yellowButton&quot;).html(&quot;&lt;em&gt;I am a blue button&lt;/em&gt;&quot;);
// set the inner html to &quot;&lt;em&gt;I am a blue button&lt;/em&gt;&quot;

$(&quot;#yellowButton&quot;).css(&quot;background-color&quot;,&quot;#002147&quot;);
// change the background color to Imperial Blue.

$(&quot;#yellowButton&quot;).addClass(&quot;big blue button&quot;);
// add classes &quot;big&quot;, &quot;blue&quot; and &quot;button&quot;

$(&quot;#yellowButton&quot;).removeClass(&quot;big&quot;);
// remove classes &quot;big&quot;

$(&quot;#yellowButton&quot;).toggleClass(&quot;pressed&quot;);
// add/remove the class &quot;pressed&quot; depending on whether the element has the class &quot;pressed&quot;

$(&quot;#yellowButton&quot;).hasClass(&quot;button&quot;);
// returns true

$(&quot;#yellowButton&quot;).on(&quot;click&quot;,function(){
    // stuff:
    $(this).toggleClass(&quot;pressed&quot;);
});
// bind the action &quot;click&quot; to the stuff
/* Other actions you can bind to using .on():
        focus
        blur
        focusin
        focusout
        change
        input        //Useful for range element
        dblclick
        mouseenter
        mouseleave
        keydown
        keypress
        keyup
        mousemove
        mouseout
        mouseover
        mouseup
        resize
        scroll
        select
        submit 
    Note that not all of them are supported by all
    types of elements. Please look them up yourself.
*/

$(&quot;#yellowButton&quot;).attr(&quot;data-message&quot;);
// returns &quot;hahaha&quot;

$(&quot;#yellowButton&quot;).width();
// returns whatever the width of the element is in px

$(&quot;#yellowButton&quot;).height();
// returns whatever the height of the element is in px
</code></pre><p>2. for the element <code>&lt;input id=&quot;someSlider&quot; class=&quot;inputs&quot; type=&quot;range&quot; value=&quot;10&quot; min =&quot;0&quot; max=&quot;10&quot; step =&quot;1&quot;/&gt;</code>, you can do:</p>
<pre><code>$(&quot;#someSlider&quot;).val();
// returns 10

$(&quot;#someSlider&quot;).val(0);
// set the slider value to 0

$(&quot;#someSlider&quot;).on(&#39;input&#39;,function(){
    console.log($(this).val());
});
// Print the value in the console as someone drags the slider.
</code></pre>
          </div>
        </div>
        <h2 id="useful-libraries">Useful Libraries</h2>
        <div class="row">
          <div class="twelve columns">
          <blockquote>Avoid hosting these libraries youself (on the server), always use the CDN if possible.<em>-Server Manager</em></blockquote>

<hr>
<h3 id="python">PYTHON</h3>
<div class="row">
  <div class="six columns">
  <h4 id="plotly">plotly</h4>
  <p>Library for data virsualisations.
  <a href="https://plot.ly/">https://plot.ly/</a>
  <em>Copyright (c) 2016-2017 Plotly, Inc</em></p>
  <ul>
  <li>Open-Source (MIT License)</li>
  <li><a href="https://github.com/plotly/plotly.py/blob/master/LICENSE.txt">https://github.com/plotly/plotly.py/blob/master/LICENSE.txt</a></li>
  </ul>
  </div>
  <div class="six columns">
  <h4 id="matplotlib">matplotlib</h4>
  <p>Library for plotting graphs (not commandeered, please use Plotly when possible).
  <a href="https://matplotlib.org">https://matplotlib.org</a>
  <em>(c) Copyright 2002 - 2012 John Hunter, Darren Dale, Eric Firing, Michael Droettboom and the Matplotlib development team</em></p>
  <ul>
  <li>Open-Source (PSF License)</li>
  <li><a href="https://matplotlib.org/users/license.html">https://matplotlib.org/users/license.html</a></li>
  </ul>
  </div>
</div>
<hr>
<h3 id="javascript">JAVASCRIPT</h3>
<div class="row">
<div class="six columns">
  <h4 id="jquery">jQuery</h4>
  <p>For easier DOM access.
  <a href="https://jquery.org/">https://jquery.org/</a>
  <em>Copyright 2017 The jQuery Foundation.</em></p>
  <ul>
  <li>Open-Source (MIT License)</li>
  <li><a href="https://jquery.org/license/">License</a></li>
  </ul>
  <h4 id="plotly">plotly</h4>
  <p>Library for data visualisations.
  <a href="https://plot.ly/">https://plot.ly/</a>
  <em>Copyright (c) 2016-2017 Plotly, Inc</em></p>
  <ul>
  <li>Open-Source (MIT License)</li>
  <li><a href="https://github.com/plotly/plotly.py/blob/master/LICENSE.txt">License</a></li>
  <li><a href="https://plot.ly/javascript/open-source-announcement/">https://plot.ly/javascript/open-source-announcement/</a></li>
  <li>Commercial use is fine as long it&#39;s as not hosted on their website <a href="https://plot.ly/terms-of-service/">https://plot.ly/terms-of-service/</a></li>
  </ul>
  <h4 id="phaser-io">phaser.io</h4>
  <p>Library for drawing stuff on Canvas. Use this instead of Plotly when you want full control over your UI.
  <a href="https://phaser.io/">https://phaser.io/</a>
  <em>Copyright (c) 2017 Richard Davey, Photon Storm Ltd.</em></p>
  <ul>
  <li>Open-Source (MIT License)</li>
  <li><a href="https://github.com/photonstorm/phaser-ce/blob/v2.8.4/license.txt">License</a></li>
  </ul>
</div>
<div class="six columns">

  <h4 id="mathjax">MathJax</h4>
  <p>For displaying LaTeX on your HTML page.
  <a href="https://www.mathjax.org/">https://www.mathjax.org/</a>
  <em>Copyright (c) 2009-2017 The MathJax Consortium</em></p>
  <ul>
  <li>Open-Source (Apache License, Version 2.0)</li>
  <li><a href="https://github.com/mathjax/MathJax/blob/master/LICENSE">License</a></li>
  </ul>
  <h4 id="marked-js">marked.js</h4>
  <p>For displaying Markdown on your HTML page.
  <a href="https://github.com/chjj/marked">https://github.com/chjj/marked</a>
  <em>Copyright (c) 2011-2014, Christopher Jeffrey (<a href="https://github.com/chjj/">https://github.com/chjj/</a>)</em></p>
  <ul>
  <li>Open-Source (MIT License)</li>
  <li><a href="https://github.com/chjj/marked/blob/master/LICENSE">License</a></li>
  </ul>
  <h4 id="jison">Jison</h4>
  <p>For converting <code>E^sqrt(3*k^2)</code> to <code>Math.pow(Math.E,Math.sqrt(3*Math.pow(k,2)))</code>
  <a href="http://zaa.ch/jison/">http://zaa.ch/jison/</a>
  <em>Copyright (c) 2009-2013 Zachary Carter</em></p>
  <ul>
  <li>Open-Source (MIT License)</li>
  <li><a href="http://zaa.ch/jison/docs/#license">License</a></li>
  </ul>
</div>
</div>
<hr>
<h3 id="css">CSS</h3>
<h4 id="skeleton">Skeleton</h4>
<p>What our current CSS is based on. We&#39;ve added a lot to it, but all the margins and paddings are determinant by Skeleton.
<a href="http://getskeleton.com/">http://getskeleton.com/</a>
<em>Copyright (c) 2011-2014 Dave Gamache</em></p>
<ul>
<li>The MIT License (MIT)</li>
<li><a href="https://github.com/dhg/Skeleton/blob/master/LICENSE.md">License</a></li>
</ul>
          </div>
        </div>
    </div>
    
  <div class="container centre-aligned">Created by <a href="mailto:hk1415@ic.ac.uk">Mangle Kuo</a>. Last update 08/09/2017.</div>
<br><br>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>

  <script type="text/javascript">    

  var paki = document.createElement('audio');
      paki.setAttribute('src', 'assets/paki.mp3');
  var paku = document.createElement('audio');
      paku.setAttribute('src', 'assets/paku.mp3');
  var climbing = document.createElement('audio');
      climbing.setAttribute('src', 'assets/climbing.mp3');
      climbing.loop = true;

    
    $(".playStopButton").on('click',function(){
      $(this).toggleClass("pressed");
      if($(this).hasClass("pressed")){
        //Pressed Play
        $(this).text("◼︎︎ STOP");
        paki.play();
        climbing.play();
      }else{
        //Pressed Stop
        $(this).text("▶︎︎ PLAY");
        paku.play();
        climbing.pause();
        climbing.currentTime = 0;
      }
    });
    
    $(".playStopButtonV3").on('click',function(){
      $(this).toggleClass("pressed");
      if($(this).hasClass("pressed")){
        //Pressed Play
        $(this).text("◼︎︎ STOP");
      }else{
        //Pressed Stop
        $(this).text("▶︎︎ PLAY");
      }
    });

    $( ":header" ).each(function(){
      if($(this).attr("id") != "" && $(this).attr("id") != undefined && $(this).attr("id") != false){
        level = parseInt(this.nodeName.substring(1));
        console.log((1500-3*level*100).toFixed(0));
        prefix = "";
        for (var i = 2; i < level; i++) {
          prefix += "&nbsp;&nbsp;";
        }
        prefix += "+&nbsp;";
        $("#MenuItemContainer").append('<li class="popover-item"><a class="popover-link" css="font-size:'+(150-3*level*10).toFixed(2)+'%;font-weight:'+(1500-3*level*100).toFixed(0)+'" href="#'+$(this).attr("id")+'">'+prefix+$(this).html()+'</a></li>');
      }
    });


    $(".colourTiles").each(function(){
      var colour = $(this).attr("data-color"); 
      $(this).css("background-color",$(this).attr("data-color")); 
      if(colour.charAt(0) == "#"){colour = colour.substring(1,7);} //remove the #
      var colours =  [
            parseInt(colour.substring(0,2) ,16),
            parseInt(colour.substring(2,4) ,16),
            parseInt(colour.substring(4,6) ,16)
        ];
      if((colours[0]*0.299 + colours[1]*0.587 + colours[2]*0.114) > 186){
        $(this).css("color","#000000");
      }else{
        $(this).css("color","#ffffff");
      }
      $(this).append('<span class="tileSubtitle">HEX</span><span class="tileValue">'+$(this).attr("data-color")+'</span>');
      $(this).append('<span class="tileSubtitle">RGB</span><span class="tileValue">'+$(this).attr("data-rgb").substr(4, $(this).attr("data-rgb").length-5) +'</span>');
      $(this).append('<span class="tileSubtitle">CMYK</span><span class="tileValue">'+$(this).attr("data-cmyk").substr(5, $(this).attr("data-cmyk").length-6)+'</span>');
      $(this).append('<span class="tileSubtitle">PMS</span><span class="tileValue">'+$(this).attr("data-pms")+'</span>');

      $(this).on('click',function(e){
        var copiedMessage = $("<div class='copied'></div>");
        $("body").append(copiedMessage);
        copiedMessage.css("left" ,e.pageX );
        copiedMessage.css("top" ,e.pageY );
        if($("#colourCopyingOptions").val() != "colorWithoutHashTag"){
          copiedMessage.text("\""+$(this).attr("data-"+$("#colourCopyingOptions").val())+"\" copied.");
        }else{
          copiedMessage.text("\""+$(this).attr("data-color").substring(1,7)+"\" copied.");
        }
        copiedMessage.fadeIn( 40, function() {
          copiedMessage.fadeOut( 1000 , function(){
            copiedMessage.remove();
          } );
        });
      });

      new Clipboard(this, {
          text: function(trigger) {
            if($("#colourCopyingOptions").val() != "colorWithoutHashTag"){
              var str = trigger.getAttribute("data-"+$("#colourCopyingOptions").val());
            }else{
              var str = trigger.getAttribute("data-color").substring(1,7);
            }
            console.log(str);
            return str;
            // return trigger.getAttribute('data-color');
          }
      });

    });

    $(function() {
      $('ul.tab-nav li a.button').click(function() {
          var href = $(this).attr('href');

          $('li a.active.button', $(this).parent().parent()).removeClass('active');
          $(this).addClass('active');

          $('.tab-pane.active', $(href).parent()).removeClass('active');
          $(href).addClass('active');

          return false;
      });
    });


  </script>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

</body>
</html>
