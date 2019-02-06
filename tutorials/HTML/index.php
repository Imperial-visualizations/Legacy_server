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
  <link rel="stylesheet" href="https://manglekuo.com/i-v/styles.css?v=5">
  <!-- <link rel="stylesheet" href="../styles/styles.css?v=3"> -->
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
  </style>

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <section class="header">
      <h1 class="title">Imperial Visualisation Cheatsheet</h1>
      <h6>Declaration: This page is an alternation of the contents on <a href="http://getskeleton.com/#">http://getskeleton.com/</a>, which is also what the Imperial Visualisation css style is based on.</h6>
    </section>

    <!-- README -->
    <div>
      <h3 id="GettingStarted">Getting Started</h3>
        <div class="row">
          <div class="seven columns">
<ol>
<li><p>Right click -> Save As <a href="./index.html">THIS FILE</a> as <em>index.html</em>.</p>
</li>
<li><p>Open <em>index.html</em> with PyCharm or whatever code-editor you like:</p>
</li>
<li><p>Start adding HTML elements by copy and paste from this page to the space between<code>&lt;div class=&quot;container&quot;&gt; &lt;/div&gt;</code> tags in your <em>index.html</em>.</p>
</li>
</ol>
          </div>
          <div class="five columns">
<pre>
<code>Recommonded folder structure for your <em>index.html</em>:

+ HTML/
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
<p>4. This is what your <em>index.html</em> should look like right now:</p>
<pre><code><strong>index.html</strong>
&lt;!doctype html&gt;
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
        &lt;h1&gt;Primary titles&lt;/h1&gt;
        &lt;div class=&quot;row&quot;&gt;
            &lt;div class=&quot;twelve columns&quot;&gt;
              Your Stuffs
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;br&gt;&lt;br&gt;&lt;br&gt;
    &lt;script src=&quot;scripts/program.js&quot;&gt;&lt;/script&gt;&lt;!-- You can iether put your code
                                                    inside this file ( which you&#39;ll
                                                    have to create yourself) --&gt;
    &lt;script&gt;
        // Or put your javascript code here.
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
</code></pre>
          </div>
        </div>
    </div>


    <div>
      <h3 id="dropdown" class="docs-header">The dropdown menu</h3>
        <ul class="dropdown">
            <li>
                <span id="Menu">Menu</span>
                <ul id="MenuItemContainer">
                </ul>
            </li>
        </ul>
      <p>Use the drop down menu as a navigation of your page.</p>
<pre>
<code>&#x3C;ul class=&#x22;dropdown&#x22;&#x3E;
            &#x3C;li&#x3E;
                &#x3C;span id=&#x22;Menu&#x22;&#x3E;Menu&#x3C;/span&#x3E;
                &#x3C;ul&#x3E;
                &#x3C;li &#x3E;
                  &#x3C;a href=&#x22;#grid&#x22;&#x3E;Grid&#x3C;/a&#x3E;
                &#x3C;/li&#x3E;
                &#x3C;li &#x3E;
                  &#x3C;a href=&#x22;#typography&#x22;&#x3E;Typography&#x3C;/a&#x3E;
                &#x3C;/li&#x3E;
                .
                .
                .
                &#x3C;li &#x3E;
                  &#x3C;a href=&#x22;#utilities&#x22;&#x3E;Utilities&#x3C;/a&#x3E;
                &#x3C;/li&#x3E;
                &#x3C;/ul&#x3E;
            &#x3C;/li&#x3E;
&#x3C;/ul&#x3E;
</code>
</pre>
    </div>

    <!-- Grid -->
    <div class="docs-section">
      <h3 class="docs-header" id="grid">The grid</h3>
      <p>The grid is a <u>12-column fluid grid with a max width of 960px</u>, that shrinks with the browser/device at smaller sizes. The max width can be changed with one line of CSS and all columns will resize accordingly. The syntax is simple and it makes coding responsive much easier. Go ahead, resize the browser. </p>
      <div class="example-grid docs-example">
        <div class="row">
          <div class="one column">One</div>
          <div class="eleven columns">Eleven</div>
        </div>
        <div class="row">
          <div class="two columns">Two</div>
          <div class="ten columns">Ten</div>
        </div>
        <div class="row">
          <div class="three columns">Three</div>
          <div class="nine columns">Nine</div>
        </div>
        <div class="row">
          <div class="four columns">Four</div>
          <div class="eight columns">Eight</div>
        </div>
        <div class="row">
          <div class="five columns">Five</div>
          <div class="seven columns">Seven</div>
        </div>
        <div class="row">
          <div class="six columns">Six</div>
          <div class="six columns">Six</div>
        </div>
        <div class="row">
          <div class="seven columns">Seven</div>
          <div class="five columns">Five</div>
        </div>
        <div class="row">
          <div class="eight columns">Eight</div>
          <div class="four  columns">Four</div>
        </div>
        <div class="row">
          <div class="nine columns">Nine</div>
          <div class="three columns">Three</div>
        </div>
        <div class="row">
          <div class="ten columns">Ten</div>
          <div class="two columns">Two</div>
        </div>
        <div class="row">
          <div class="eleven columns">Eleven</div>
          <div class="one column">One</div>
        </div>
      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint"><!-- .container is main centered wrapper -->
&lt;!-- .container is main centered wrapper --&gt;
&lt;div class="container"&gt;

  &lt;!-- columns should be the immediate child of a .row --&gt;
  &lt;div class="row"&gt;
    &lt;div class="one column"&gt;One&lt;/div&gt;
    &lt;div class="eleven columns"&gt;Eleven&lt;/div&gt;
  &lt;/div&gt;

  &lt;!-- just use a number and class 'column' or 'columns' --&gt;
  &lt;div class="row"&gt;
    &lt;div class="two columns"&gt;Two&lt;/div&gt;
    &lt;div class="ten columns"&gt;Ten&lt;/div&gt;
  &lt;/div&gt;

  &lt;!-- there are a few shorthand columns widths as well --&gt;
  &lt;div class="row"&gt;
    &lt;div class="one-third column"&gt;1/3&lt;/div&gt;
    &lt;div class="two-thirds column"&gt;2/3&lt;/div&gt;
  &lt;/div&gt;
  &lt;div class="row"&gt;
    &lt;div class="one-half column"&gt;1/2&lt;/div&gt;
    &lt;div class="one-half column"&gt;1/2&lt;/div&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;!-- Note: columns can be nested, but it's not recommended since Skeleton's grid has %-based gutters,
meaning a nested grid results in variable with gutters (which can end up being *really* small on certain
browser/device sizes) --&gt;

</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->


    </div>

    <!-- Typography -->
    <div>
      <h3 id="typography">Typography</h3>
      <p>Type is all set with the <code>rems</code>, so font-sizes and spacial relationships can be responsively sized based on a single <code>&lt;html&gt;</code> font-size property. Out of the box, Skeleton never changes the <code>&lt;html&gt;</code> font-size, but it's there in case you need it for your project. All measurements are still base 10 though so, an <code>&lt;h1&gt;</code> with <code>5.0rem</code>font-size just means <code>50px</code>.</p>
      <div>
        <div class="row">
          <div class="six columns">
            <p><strong>The typography base</strong> is <a href="https://fonts.google.com/specimen/Fira+Sans">Fira Sans</a> served by Google, set at 15rem (15px) over a 1.6 line height (24px). Other type basics like <a href="#">anchors</a>, <strong>strong</strong>, <em>emphasis</em>, and <u>underline</u> are all obviously included. In the css we have <code>font-weight</code> 300,400,500,600,700 imported.</p>
            <p><strong>Headings</strong> create a family of distinct sizes each with specific <code>letter-spacing</code>, <code>line-height</code>, and <code>margins</code>.</p>
          </div>
          <div class="six columns">
            <h1>Heading<span class="heading-font-size"> <code>&lt;h1&gt;</code> 50rem</span></h1>
            <h2>Heading<span class="heading-font-size"> <code>&lt;h2&gt;</code> 42rem</span></h2>
            <h3>Heading<span class="heading-font-size"> <code>&lt;h3&gt;</code> 36rem</span></h3>
            <h4>Heading<span class="heading-font-size"> <code>&lt;h4&gt;</code> 30rem</span></h4>
            <h5>Heading<span class="heading-font-size"> <code>&lt;h5&gt;</code> 24rem</span></h5>
            <h6>Heading<span class="heading-font-size"> <code>&lt;h6&gt;</code> 15rem</span></h3>
          </div>
        </div>
      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint"><!-- Standard Headings -->
&lt;!-- Standard Headings --&gt;
&lt;h1&gt;Heading&lt;/h1&gt;
&lt;h2&gt;Heading&lt;/h2&gt;
&lt;h3&gt;Heading&lt;/h3&gt;
&lt;h4&gt;Heading&lt;/h4&gt;
&lt;h5&gt;Heading&lt;/h5&gt;
&lt;h6&gt;Heading&lt;/h6&gt;

&lt;!-- Base type size --&gt;
&lt;p&gt;The base type is 15px over 1.6 line height (24px)&lt;/p&gt;

&lt;!-- Other styled text tags --&gt;
&lt;strong&gt;Bolded&lt;/strong&gt;
&lt;em&gt;Italicized&lt;/em&gt;
&lt;a&gt;Colored&lt;/a&gt;
&lt;u&gt;Underlined&lt;/u&gt;

</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->


    </div>

    <!-- Buttons -->
    <div class="docs-section">
      <h3 class="docs-header" id="buttons">Buttons</h3>
      <p>Buttons come in two basic flavors in Skeleton. The standard <code>&lt;button&gt;</code> element is plain, whereas the <code>.button-primary</code> button is vibrant and prominent. Button styles are applied to a number of appropriate form elements, but can also be arbitrarily attached to anchors with a <code>.button</code> class.</p>
      <div class="docs-example">
        <div>
          <a class="button" href="#">Anchor button</a>
          <button>Button element</button>
          <input type="submit" value="submit input">
          <input type="button" value="button input">
        </div>
        <div>
          <a class="button button-primary" href="#">Anchor button</a>
          <button class="button-primary">Button element</button>
          <input class="button-primary" type="submit" value="submit input">
          <input class="button-primary" type="button" value="button input">
        </div>
      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint"><!-- Standard buttons -->
&lt;!-- Standard buttons --&gt;
&lt;a class="button" href="#"&gt;Anchor button&lt;/a&gt;
&lt;button&gt;Button element&lt;/button&gt;
&lt;input type="submit" value="submit input"&gt;
&lt;input type="button" value="button input"&gt;

&lt;!-- Primary buttons --&gt;
&lt;a class="button button-primary" href="#"&gt;Anchor button&lt;/a&gt;
&lt;button class="button-primary"&gt;Button element&lt;/button&gt;
&lt;input class="button-primary" type="submit" value="submit input"&gt;
&lt;input class="button-primary" type="button" value="button input"&gt;

</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->


    </div>

    <!-- Forms -->
    <div class="docs-section">
      <h3 class="docs-header" id="forms">Forms</h3>
      <p>Forms are a huge pain, but hopefully these styles make it a bit easier. All inputs, select, and buttons are normalized for a common height cross-browser so inputs can be stacked or placed alongside each other.</p>
      <div class="docs-example docs-example-forms">
        <form>
          <h2 class="centre-aligned">Feedback Form</h4>
          <div class="row">
            <div class="twelve columns">
              <label class="radioTitle">I'm a: </label>
              <label class="radio" for="student">
                  <input type="radio" name="studentOrStuff" value="student" id="student" checked />
                  <span>Student</span>
              </label>
              <label class="radio" for="staff">
                  <input type="radio" name="studentOrStuff" value="staff" id="staff"/>
                  <span>Staff</span>
              </label>
            </div>
          </div>
          <div class="row">
            <div class="six columns">
                <label>Office Location:</label>
                <input class="u-full-width" type="text" placeholder="BLK314" id="officeLocation" disabled="disabled">
            </div>
            <div class="six columns">
              <label>Department:</label>
              <select class="u-full-width" id="department">
              <optgroup label="Faculty of Engineering">
                <option value="Aeronautics">Aeronautics</option>
                <option value="Bioengineering">Bioengineering</option>
                <option value="Chemical Engineering">Chemical Engineering</option>
                <option value="Civil and Environmental Engineering">Civil and Environmental Engineering</option>
                <option value="Computing">Computing</option>
                <option value="Dyson School of Design Engineering">Dyson School of Design Engineering</option>
                <option value="Earth Science and Engineering">Earth Science and Engineering</option>
                <option value="Electrical and Electronic Engineering">Electrical and Electronic Engineering</option>
                <option value="Materials">Materials</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
              </optgroup>
              <optgroup label="Faculty of Medicine">
                <option value="Institute of Clinical Sciences">Institute of Clinical Sciences</option>
                <option value="Department of Medicine">Department of Medicine</option>
                <option value="National Heart and Lung Institute">National Heart and Lung Institute</option>
                <option value="School of Public Health">School of Public Health</option>
                <option value="Department of Surgery and Cancer">Department of Surgery and Cancer</option>
                <option value="Lee Kong Chian School of Medicine - London Office">Lee Kong Chian School of Medicine - London Office</option>
                <option value="Imperial College Academic Health Science Centre">Imperial College Academic Health Science Centre</option>
                <option value="Imperial College Healthcare NHS Trust">Imperial College Healthcare NHS Trust</option>
              </optgroup>
              <optgroup label="Faculty of Natural Sciences">
                <option value="Chemistry">Chemistry</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Physics">Physics</option>
                <option value="Life Sciences">Life Sciences</option>
                <option value="Centre for Environmental Policy">Centre for Environmental Policy</option>
              </optgroup>
              <optgroup label="Imperial College Business School">
                <option value="Finance">Finance</option>
                <option value="Innovation and Entrepreneurship">Innovation and Entrepreneurship</option>
                <option value="Management">Management</option>
              </optgroup>
              <optgroup label="Global challenge institutes">
                <option value="Data Science Institute">Data Science Institute</option>
                <option value="Grantham Institute - Climate Change and the Environment">Grantham Institute - Climate Change and the Environment</option>
                <option value="Institute of Global Health Innovation">Institute of Global Health Innovation</option>
                <option value="Energy Futures Lab">Energy Futures Lab</option>
                <option value="Institute for Security Science and Technology">Institute for Security Science and Technology</option>
                <option value="Institute for Molecular Science and Engineering">Institute for Molecular Science and Engineering</option>
              </optgroup>
              <optgroup label="Education centres and schools">
                <option value="Careers Service">Careers Service</option>
                <option value="Centre for Academic English">Centre for Academic English</option>
                <option value="Centre for Languages, Culture and Communication">Centre for Languages, Culture and Communication</option>
                <option value="Educational Development Unit">Educational Development Unit</option>
                <option value="Graduate School">Graduate School</option>
                <option value="Library">Library</option>
                <option value="Post Doc Development Centre">Post Doc Development Centre</option>
                <option value="School of Professional Development">School of Professional Development</option>
              </optgroup>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="six columns">
              <label>School email:</label>
              <input class="u-full-width" type="email" placeholder="ab1219@ic.ac.uk" id="email">
            </div>
            <div class="six columns">
                <label>Phone Number:</label>
                <input class="u-full-width" type="tel" placeholder="07888888888" id="phoneNumber">
            </div>
          </div>
          <div class="row">
            <div class="twelve columns">
              <label>Feedbacks:</label>
              <textarea class="u-full-width" placeholder="Hi Dave &hellip;" id="feedbacks"></textarea>
            </div>
          </div>
          <div class="row">
          <div class="six columns">
            <label class="radioTitle">My gender is: </label>
            <label class="radio" for="male">
                <input type="radio" name="gender" value="male" id="male" checked />
                <span>Male</span>
            </label>
            <label class="radio" for="female">
                <input type="radio" name="gender" value="female" id="female"/>
                <span>Female</span>
            </label>
            <label class="radio" for="else">
                <input type="radio" name="gender" value="else" id="else"/>
                <span>Else/Prefer not to say</span>
            </label>
          </div>
          <div class="six columns">
            <label class="sliderTitle">Overall Ranking: <span id="rankingDisplay" data-unit=" stars">10 stars</span></label>
            <label class="slider">
            <input id="ranking" class="inputs" type="range" value="10" min ="0" max="10" step ="1"/>
            <span class="sliderMin">0(worst)</span><span class="sliderMax">10(satisfactory)</span>
            </label>
          </div>
          <div class="row">
          <div class="twelve columns">
            <label class="checkbox" data-title="I give permission for the school to contact me regarding my feedbacks.">
                <input type="checkbox" id="permission" checked /><span for="checkbox"></span>
            </label>
            <br>
            <input class="button-primary centre-aligned u-full-width" type="button" value="Submit">
          </div>
          </div>
        </form>
      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint"><!-- The above form looks like this -->
&lt;!-- The above form looks like this --&gt;
        &lt;form&gt;
          &lt;h2 class=&quot;centre-aligned&quot;&gt;Feedback Form&lt;/h4&gt;
          &lt;div class=&quot;row&quot;&gt;
            &lt;div class=&quot;twelve columns&quot;&gt;
              &lt;label class=&quot;radioTitle&quot;&gt;I&#39;m a: &lt;/label&gt;
              &lt;label class=&quot;radio&quot; for=&quot;student&quot;&gt;
                  &lt;input type=&quot;radio&quot; name=&quot;studentOrStuff&quot; value=&quot;student&quot; id=&quot;student&quot; checked /&gt;
                  &lt;span&gt;Student&lt;/span&gt;
              &lt;/label&gt;
              &lt;label class=&quot;radio&quot; for=&quot;staff&quot;&gt;
                  &lt;input type=&quot;radio&quot; name=&quot;studentOrStuff&quot; value=&quot;staff&quot; id=&quot;staff&quot;/&gt;
                  &lt;span&gt;Staff&lt;/span&gt;
              &lt;/label&gt;
            &lt;/div&gt;
          &lt;/div&gt;
          &lt;div class=&quot;row&quot;&gt;
            &lt;div class=&quot;six columns&quot;&gt;
                &lt;label&gt;Office Location:&lt;/label&gt;
                &lt;input class=&quot;u-full-width&quot; type=&quot;text&quot; placeholder=&quot;BLK314&quot; id=&quot;officeLocation&quot; disabled=&quot;disabled&quot;&gt;
            &lt;/div&gt;
            &lt;div class=&quot;six columns&quot;&gt;
              &lt;label&gt;Department:&lt;/label&gt;
              &lt;select class=&quot;u-full-width&quot; id=&quot;department&quot;&gt;
              &lt;optgroup label=&quot;Faculty of Engineering&quot;&gt;
                &lt;option value=&quot;Aeronautics&quot;&gt;Aeronautics&lt;/option&gt;
                &lt;option value=&quot;Bioengineering&quot;&gt;Bioengineering&lt;/option&gt;
                &lt;option value=&quot;Chemical Engineering&quot;&gt;Chemical Engineering&lt;/option&gt;
                &lt;option value=&quot;Civil and Environmental Engineering&quot;&gt;Civil and Environmental Engineering&lt;/option&gt;
              .
              .
              .
              .
              &lt;/optgroup&gt;
              .
              .
              .
              .
              &lt;/select&gt;
            &lt;/div&gt;
          &lt;/div&gt;
          &lt;div class=&quot;row&quot;&gt;
            &lt;div class=&quot;six columns&quot;&gt;
              &lt;label&gt;School email:&lt;/label&gt;
              &lt;input class=&quot;u-full-width&quot; type=&quot;email&quot; placeholder=&quot;ab1219@ic.ac.uk&quot; id=&quot;email&quot;&gt;
            &lt;/div&gt;
            &lt;div class=&quot;six columns&quot;&gt;
                &lt;label&gt;Phone Number:&lt;/label&gt;
                &lt;input class=&quot;u-full-width&quot; type=&quot;tel&quot; placeholder=&quot;07888888888&quot; id=&quot;phoneNumber&quot;&gt;
            &lt;/div&gt;
          &lt;/div&gt;
          &lt;div class=&quot;row&quot;&gt;
            &lt;div class=&quot;twelve columns&quot;&gt;
              &lt;label&gt;Feedbacks:&lt;/label&gt;
              &lt;textarea class=&quot;u-full-width&quot; placeholder=&quot;Hi Dave &amp;hellip;&quot; id=&quot;feedbacks&quot;&gt;&lt;/textarea&gt;
            &lt;/div&gt;
          &lt;/div&gt;
          &lt;div class=&quot;row&quot;&gt;
          &lt;div class=&quot;six columns&quot;&gt;
            &lt;label class=&quot;radioTitle&quot;&gt;My gender is: &lt;/label&gt;
            &lt;label class=&quot;radio&quot; for=&quot;male&quot;&gt;
                &lt;input type=&quot;radio&quot; name=&quot;gender&quot; value=&quot;male&quot; id=&quot;male&quot; checked /&gt;
                &lt;span&gt;Male&lt;/span&gt;
            &lt;/label&gt;
            &lt;label class=&quot;radio&quot; for=&quot;female&quot;&gt;
                &lt;input type=&quot;radio&quot; name=&quot;gender&quot; value=&quot;female&quot; id=&quot;female&quot;/&gt;
                &lt;span&gt;Female&lt;/span&gt;
            &lt;/label&gt;
            &lt;label class=&quot;radio&quot; for=&quot;else&quot;&gt;
                &lt;input type=&quot;radio&quot; name=&quot;gender&quot; value=&quot;else&quot; id=&quot;else&quot;/&gt;
                &lt;span&gt;Else/Prefer not to say&lt;/span&gt;
            &lt;/label&gt;
          &lt;/div&gt;
          &lt;div class=&quot;six columns&quot;&gt;
            &lt;label class=&quot;sliderTitle&quot;&gt;Overall Ranking: &lt;span id=&quot;rankingDisplay&quot; data-unit=&quot; stars&quot;&gt;10 stars&lt;/span&gt;&lt;/label&gt;
            &lt;label class=&quot;slider&quot;&gt;
            &lt;input id=&quot;ranking&quot; class=&quot;inputs&quot; type=&quot;range&quot; value=&quot;10&quot; min =&quot;0&quot; max=&quot;10&quot; step =&quot;1&quot;/&gt;
            &lt;span class=&quot;sliderMin&quot;&gt;0(worst)&lt;/span&gt;&lt;span class=&quot;sliderMax&quot;&gt;10(satisfactory)&lt;/span&gt;
            &lt;/label&gt;
          &lt;/div&gt;
          &lt;div class=&quot;row&quot;&gt;
          &lt;div class=&quot;twelve columns&quot;&gt;
            &lt;label class=&quot;checkbox&quot; data-title=&quot;I give permission for the school to contact me regarding my feedbacks.&quot;&gt;
                &lt;input type=&quot;checkbox&quot; id=&quot;permission&quot; checked /&gt;&lt;span for=&quot;checkbox&quot;&gt;&lt;/span&gt;
            &lt;/label&gt;
            &lt;!-- ↓ THIS IS THE OLD HTML ⬇︎ PLEASE CHANGE TO THE ↑ NEW ONE ⬆︎
            &lt;label class=&quot;checkbox&quot;&gt;
                &lt;input type=&quot;checkbox&quot; id=&quot;permission&quot; checked /&gt;&lt;span for=&quot;checkbox&quot;&gt;&lt;/span&gt;
            &lt;/label&gt;
            &lt;label class=&quot;checkboxTitle&quot;&gt;I give permission for the school to contact me regarding my feedbacks.&lt;/label&gt;
             --&gt;
            &lt;br&gt;
            &lt;input class=&quot;button-primary centre-aligned u-full-width&quot; type=&quot;button&quot; value=&quot;Submit&quot;&gt;
          &lt;/div&gt;
          &lt;/div&gt;
        &lt;/form&gt;

&lt;!-- Note: The class .u-full-width is just a utility class shorthand for width: 100% --&gt;

</code>
</pre>
<p> The checkbox and radio elements requires extra <code>&lt;label&#x3E; and &lt;span&#x3E;</code> elements to work. </p>
<p> The complete slider includes two label tag, one with class "sliderTitle", one with class "slider". In the sliderTitle the ID of the span has to be the ID of the input element + "Display", for the value display to work. </p>
<p> The slider value display requires the following jQuery to work: </p>
<pre>
<code>$("input[type=range]").each(function () {
  $(this).on('input', function(){
        $("#"+$(this).attr("id") + "Display").text(  $(this).val() + $("#"+$(this).attr("id")+"Display").attr("data-unit")  );
  });
});

</code>
</pre>
<p> You can disale/enable input elements in jQuery by doing:</p>
<pre>
<code>$("#elementToDisable").prop("disabled",true);
$("#elementToDisable").prop("disabled",false);
</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->


    </div>

    <!-- Lists -->
    <div class="docs-section">
      <h3 class="docs-header" id="lists">Lists</h3>
      <div class="row docs-example">
        <div class="six columns">
          <ul>
            <li>Unordered lists have basic styles</li>
            <li>
              They use the circle list style
              <ul>
                <li>Nested lists styled to feel right</li>
                <li>Can nest either type of list into the other</li>
              </ul>
            </li>
            <li>Just more list items mama san</li>
          </ul>
        </div>
        <div class="six columns">
          <ol>
            <li>Ordered lists also have basic styles</li>
            <li>
              They use the decimal list style
              <ul>
                <li>Ordered and unordered can be nested</li>
                <li>Can nest either type of list into the other</li>
              </ul>
            </li>
            <li>Last list item just for the fun</li>
          </ol>
        </div>
      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint">
&lt;ul&gt;
  &lt;li&gt;Item 1&lt;/li&gt;
  &lt;li&gt;
    Item 2
    &lt;ul&gt;
      &lt;li&gt;Item 2.1&lt;/li&gt;
      &lt;li&gt;Item 2.2&lt;/li&gt;
    &lt;/ul&gt;
  &lt;/li&gt;
  &lt;li&gt;Item 3&lt;/li&gt;
&lt;/ul&gt;

&lt;!-- Easily substitute any &lt;ul&gt; or an &lt;ol&gt; to get number lists or sublists. Skeleton doesn't support lists nested deeper than 2 levels --&gt;

</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->


    </div>

    <!-- Code -->
    <div class="docs-section" id="code">
      <h3 class="docs-header">Code</h3>
      <p>Code styling is kept basic – just wrap anything in a <code>&lt;code&gt;</code> and it will appear like <code>this</code>. For blocks of code, wrap a <code>&lt;code&gt;</code> with a <code>&lt;pre&gt;</code>.</p>
      <div class="docs-example">
<pre><code>.some-class {
  background-color: red;
}</code></pre>
      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint">
&lt;pre&gt;&lt;code&gt;.some-class {
  background-color: red;
}&lt;/code&gt;&lt;/pre&gt;

&lt;!-- Remember every whitespace and break will be preserved in a &lt;pre&gt;, including indentation in your code --&gt;

</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->


    </div>


    <!-- Tabs -->
<div class="docs-section">
  <h3 class="docs-header" id="tabs">Tabs</h3>
  <div class="row docs-example">
    <div class="six columns">
      <p>The tab requires jQuery to work properly. If you don't understand jQuery, please see <a href="../DOM/DoubleClickMe.html">tutorial/DOM/DoubleClickMe.html</a> .</p>
    </div>
    <div class="six columns">
       <ul class="tab-nav">
          <li>
            <a class="button active" href="#one">Tab 1</a>
          </li>
          <li>
            <a class="button" href="#two">Tab 2</a>
          </li>
          <li>
            <a class="button" href="#three">Tab 3</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="one">
            <h5>Tab 1</h5>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto
             beatae vitae dicta sunt explicabo.</p>
          </div>
          <div class="tab-pane" id="two">
            <h5>Tab 2</h5>
            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
             consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
          </div>
          <div class="tab-pane" id="three">
            <h5>Tab 3</h5>
            <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci
            velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam
            quaerat voluptatem.</p>
          </div>
        </div>
      </div>
  <div class="row docs-example">
       <div class="twelve columns">
<!-- CODE EXAMPLE ———————————————————————————————————————— -->
Html code:
<pre class="code-example">
<code class="code-example-body prettyprint">
       &#x3C;ul class=&#x22;tab-nav&#x22;&#x3E;
          &#x3C;li&#x3E;
            &#x3C;a class=&#x22;button active&#x22; href=&#x22;#one&#x22;&#x3E;Tab 1&#x3C;/a&#x3E;
          &#x3C;/li&#x3E;
          &#x3C;li&#x3E;
            &#x3C;a class=&#x22;button&#x22; href=&#x22;#two&#x22;&#x3E;Tab 2&#x3C;/a&#x3E;
          &#x3C;/li&#x3E;
          &#x3C;li&#x3E;
            &#x3C;a class=&#x22;button&#x22; href=&#x22;#three&#x22;&#x3E;Tab 3&#x3C;/a&#x3E;
          &#x3C;/li&#x3E;
        &#x3C;/ul&#x3E;
        &#x3C;div class=&#x22;tab-content&#x22;&#x3E;
          &#x3C;div class=&#x22;tab-pane active&#x22; id=&#x22;one&#x22;&#x3E;
            &#x3C;h5&#x3E;Tab 1&#x3C;/h5&#x3E;
            &#x3C;p&#x3E;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
            architecto beatae vitae dicta sunt explicabo.&#x3C;/p&#x3E;
          &#x3C;/div&#x3E;
          &#x3C;div class=&#x22;tab-pane&#x22; id=&#x22;two&#x22;&#x3E;
            &#x3C;h5&#x3E;Tab 2&#x3C;/h5&#x3E;
            &#x3C;p&#x3E;Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed
            quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.&#x3C;/p&#x3E;
          &#x3C;/div&#x3E;
          &#x3C;div class=&#x22;tab-pane&#x22; id=&#x22;three&#x22;&#x3E;
            &#x3C;h5&#x3E;Tab 3&#x3C;/h5&#x3E;
            &#x3C;p&#x3E;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
            adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam
            aliquam quaerat voluptatem.&#x3C;/p&#x3E;
          &#x3C;/div&#x3E;
        &#x3C;/div&#x3E;

</code>
</pre>
jQuery code:
<pre class="code-example">
<code class="code-example-body prettyprint">
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
</code>
</pre>
    </div>
  </div>
</div>
    <!-- Tables & Matrix -->
    <div class="docs-section">
      <h3 class="docs-header" id="tablesNmatrix">Tables & Matrix</h3>
      <p>Be sure to use properly formed table markup with <code>&lt;thead&gt;</code> and <code>&lt;tbody&gt;</code> when building a <code>table</code>.</p>
      <div class="docs-example">
        <table class="u-full-width">
          <thead>
            <tr>
              <th>Name</th>
              <th>Age</th>
              <th>Sex</th>
              <th>Location</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Dave Gamache</td>
              <td>26</td>
              <td>Male</td>
              <td>San Francisco</td>
            </tr>
            <tr>
              <td>Dwayne Johnson</td>
              <td>42</td>
              <td>Male</td>
              <td>Hayward</td>
            </tr>
          </tbody>
        </table>
      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint">
&lt;table class="u-full-width"&gt;
  &lt;thead&gt;
    &lt;tr&gt;
      &lt;th&gt;Name&lt;/th&gt;
      &lt;th&gt;Age&lt;/th&gt;
      &lt;th&gt;Sex&lt;/th&gt;
      &lt;th&gt;Location&lt;/th&gt;
    &lt;/tr&gt;
  &lt;/thead&gt;
  &lt;tbody&gt;
    &lt;tr&gt;
      &lt;td&gt;Dave Gamache&lt;/td&gt;
      &lt;td&gt;26&lt;/td&gt;
      &lt;td&gt;Male&lt;/td&gt;
      &lt;td&gt;San Francisco&lt;/td&gt;
    &lt;/tr&gt;
    &lt;tr&gt;
      &lt;td&gt;Dwayne Johnson&lt;/td&gt;
      &lt;td&gt;42&lt;/td&gt;
      &lt;td&gt;Male&lt;/td&gt;
      &lt;td&gt;Hayward&lt;/td&gt;
    &lt;/tr&gt;
  &lt;/tbody&gt;
&lt;/table&gt;

</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->

      <div class="docs-example">
        <p>For matrix, just add the class &quot;matrix&quot; to the <code>&lt;table&gt;</code> tag, and use only <code>&lt;tbody&gt;</code>, <code>&lt;tr&gt;</code> and <code>&lt;td&gt;</code> inside it. Do not use <code>&lt;thead&gt;</code> or <code>&lt;th&gt;</code>. Here we are showing how you can wrap your matrices inside another table with the class &quot;matrixWrapper&quot; for easy formatting.</p>

        <table class="matrixWrapper">
          <tbody>
            <tr>
              <td>

                    <table class="matrix">
                      <tbody>
                        <tr>
                          <td>cos(θ)</td>
                          <td>-sin(θ)</td>
                        </tr>
                        <tr>
                          <td>sin(θ)</td>
                          <td>cos(θ)</td>
                        </tr>
                      </tbody>
                    </table>

              </td>
              <td>×</td>
              <td>

                    <table class="matrix">
                      <tbody>
                        <tr>
                          <td>x</td>
                        </tr>
                        <tr>
                          <td>y</td>
                        </tr>
                      </tbody>
                    </table>

              </td>
              <td>＝</td>
              <td>

                    <table class="matrix">
                      <tbody>
                        <tr>
                          <td>x cos(θ) - y sin(θ)</td>
                        </tr>
                        <tr>
                          <td>x sin(θ) + y cos(θ)</td>
                        </tr>
                      </tbody>
                    </table>

              </td>
            </tr>
          </tbody>
        </table>

      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint">        &lt;table class=&quot;matrixWrapper&quot;&gt;
          &lt;tbody&gt;
            &lt;tr&gt;
              &lt;td&gt;

                    &lt;table class=&quot;matrix&quot;&gt;
                      &lt;tbody&gt;
                        &lt;tr&gt;
                          &lt;td&gt;cos(θ)&lt;/td&gt;
                          &lt;td&gt;-sin(θ)&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                          &lt;td&gt;sin(θ)&lt;/td&gt;
                          &lt;td&gt;cos(θ)&lt;/td&gt;
                        &lt;/tr&gt;
                      &lt;/tbody&gt;
                    &lt;/table&gt;

              &lt;/td&gt;
              &lt;td&gt;×&lt;/td&gt;
              &lt;td&gt;

                    &lt;table class=&quot;matrix&quot;&gt;
                      &lt;tbody&gt;
                        &lt;tr&gt;
                          &lt;td&gt;x&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                          &lt;td&gt;y&lt;/td&gt;
                        &lt;/tr&gt;
                      &lt;/tbody&gt;
                    &lt;/table&gt;

              &lt;/td&gt;
              &lt;td&gt;＝&lt;/td&gt;
              &lt;td&gt;

                    &lt;table class=&quot;matrix&quot;&gt;
                      &lt;tbody&gt;
                        &lt;tr&gt;
                          &lt;td&gt;x cos(θ) - y sin(θ)&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                          &lt;td&gt;x sin(θ) + y cos(θ)&lt;/td&gt;
                        &lt;/tr&gt;
                      &lt;/tbody&gt;
                    &lt;/table&gt;

              &lt;/td&gt;
            &lt;/tr&gt;
          &lt;/tbody&gt;
        &lt;/table&gt;
</code>
</pre>






    </div>

    <!-- Queries -->
    <div class="docs-section">
      <h3 class="docs-header" id="queries">Media queries</h3>
      <p>Skeleton uses media queries to serve its scalable grid, but also has a list of queries for convenience of styling your site across devices. The queries are mobile-first, meaning they target <code>min-width</code>. Mobile-first queries are how Skeleton's grid is built and is the preferrable method of organizing CSS. It means all styles outside of a query apply to all devices, then larger devices are targeted for enhancement. This prevents small devices from having to parse tons of unused CSS. The sizes for the queries are:</p>
      <div class="docs-example row">
        <div class="six columns">
          <ul>
            <li><strong>Desktop HD</strong>: 1200px</li>
            <li><strong>Desktop</strong>: 1000px</li>
            <li><strong>Tablet</strong>: 750px</li>
          </ul>
        </div>
        <div class="six columns">
          <ul>
            <li><strong>Phablet</strong>: 550px</li>
            <li><strong>Mobile</strong>: 400px</li>
          </ul>
        </div>
      </div>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint">/* Mobile first queries */

/* Larger than mobile */
@media (min-width: 400px) {}

/* Larger than phablet */
@media (min-width: 550px) {}

/* Larger than tablet */
@media (min-width: 750px) {}

/* Larger than desktop */
@media (min-width: 1000px) {}

/* Larger than Desktop HD */
@media (min-width: 1200px) {}


</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->


    </div>


    <!-- Utilities and Misc. -->
    <div class="docs-section">
      <h3 class="docs-header" id="utilities">Utilities</h3>
      <p>Skeleton has a number of small utility classes that act as easy-to-use helpers. Sometimes it's better to use a utility class than create a whole new class just to float an element.</p>


<!-- CODE EXAMPLE ———————————————————————————————————————— -->
<pre class="code-example">
<code class="code-example-body prettyprint">/* Utility Classes */
/* Make element full width */
.u-full-width {
  width: 100%;
  box-sizing: border-box;
}

.u-half-width {
  width: 50%;
  box-sizing: border-box;
}
.u-quarter-width {
  width: 25%;
  box-sizing: border-box;
}

/* Make sure elements don't run outside containers (great for images in columns) */
.u-max-full-width {
  max-width: 100%;
  box-sizing: border-box; }

/* Make the text inside center aligned */
.centre-aligned{
  text-align: center;
  vertical-align: middle;
}

/* Float either direction */
.u-pull-right {
  float: right; }
.u-pull-left {
  float: left; }

/* Clear a float */
.u-cf {
  content: "";
  display: table;
  clear: both; }

</code>
</pre>
<!-- ————————————————————————————————————————————————————— -->
    </div>
  </div>

  <div class="container centre-aligned">Created by <a href="mailto:hk1415@ic.ac.uk">Mangle Kuo</a>. Last update 08/09/2017.</div>
<br><br>



  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript">
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

    $("input[type=range]").each(function () {
      $(this).on('input', function(){
            $("#"+$(this).attr("id") + "Display").text(  $(this).val() + $("#"+$(this).attr("id")+"Display").attr("data-unit")  );
      });
    });

    $( ":header" ).each(function(){
      if($(this).attr("id") != "" && $(this).attr("id") != undefined && $(this).attr("id") != false){
        $("#MenuItemContainer").append('<li class="popover-item"><a class="popover-link" href="#'+$(this).attr("id")+'">'+$(this).html()+'</a></li>');
      }
    });

    $("input[type=radio][name=studentOrStuff]").on('click',function(){
      var isStuff = !($('input[name=studentOrStuff]:checked').val() == "student");
      $("#officeLocation").prop("disabled",!isStuff);
    });

  </script>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
