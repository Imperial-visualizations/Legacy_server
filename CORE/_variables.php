<?php 
//course_code = 01001 format
$course_code = array(
	array(
		array("Department"=>"Physics","Year"=>"1","Name"=>"Mechanics"), //Prof Horbury
		array("Department"=>"Physics","Year"=>"1","Name"=>"Vibrations & Waves"), //Dr Tangney
		array("Department"=>"Physics","Year"=>"1","Name"=>"Mathematics (Complex Analysis)"), //Prof McCall
		array("Department"=>"Physics","Year"=>"1","Name"=>"Mathematics (Functions)"), //Prof Parry
		array("Department"=>"Physics","Year"=>"1","Name"=>"Mathematics (Vectors)"), //Prof Vvedensky
		array("Department"=>"Physics","Year"=>"1","Name"=>"Mathematics (Matrices)"), //Prof Vvedensky
		array("Department"=>"Physics","Year"=>"1","Name"=>"Mathematics (Vector Calculus)"), //Dr Galand
		array("Department"=>"Physics","Year"=>"1","Name"=>"Electricity and Magnetism 1"), //Prof McCall / Dr Tymms
		array("Department"=>"Physics","Year"=>"1","Name"=>"Relativity"), //Dr Clewley
		array("Department"=>"Physics","Year"=>"1","Name"=>"Quantum Physics"), //Prof Marangos
		array("Department"=>"Physics","Year"=>"1","Name"=>"Structure of Matter"), //Dr Ekins-Daukes
		array("Department"=>"Physics","Year"=>"1","Name"=>"Mathematical Analysis"), //Prof Wiseman

		array("Department"=>"Physics","Year"=>"2","Name"=>"Maths: Differential Equations"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Maths: Fourier"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Thermodynamics"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Atomic Physics [Year 2]"), //Prof Richard Thompson
		array("Department"=>"Physics","Year"=>"2","Name"=>"Electromagnetism"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Nuclear & Particle Physics [Year2] "), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Solid State Physics [Year 2]"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Quantum Mechanics"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Statistical Physics"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Statistics of Measurement"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Optics"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Sun, Stars and Planets"), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Mathematical Methods "), //Prof 
		array("Department"=>"Physics","Year"=>"2","Name"=>"Environmental Physics") //Prof 
	),
	array(
		array("Department"=>"Chemistry","Year"=>"1","Name"=>"Chemistry Coursework 1"),
		array("Department"=>"Chemistry","Year"=>"1","Name"=>"Inorganic Chemistry 1"),
		array("Department"=>"Chemistry","Year"=>"1","Name"=>"Introduction to Chemistry"),
		array("Department"=>"Chemistry","Year"=>"1","Name"=>"Organic Chemistry 1"),
		array("Department"=>"Chemistry","Year"=>"1","Name"=>"Physical Chemistry 1"),
		array("Department"=>"Chemistry","Year"=>"1","Name"=>"Medicinal Chemistry 1"),
		array("Department"=>"Chemistry","Year"=>"1","Name"=>"Maths and Physics for Chemists 1")
	)
);


//	["id","display name","link to their website","link to file (if it's locally than use link from root/visualisations/example/index.html)","isCompulsory?1:0", isInHead?1:0] 
$CSS = [
	["css_imperial_visualisations","ImperialVisualisations","http://visualisations.ph.ic.ac.uk/tutorials/HTML/DoubleClickMe.html","https://ghcpuman902.github.io/styles/styles.css",1,1],
	["css_font_awesome","Font Awesome","http://fontawesome.io/","/assets/font-awesome-4.7.0/css/font-awesome.min.css",0,1]
];
//	["id","display name","link to their website","link to file (if it's locally than use link from root/visualisations/example/index.html)",isCompulsory?1:0, isAsync?1:0] 
$JS = [
	["js_jquery","jQuery","https://jquery.org/","https://code.jquery.com/jquery-3.2.1.min.js",1,1],
	["js_skeleton_tabs","skeleton-tabs.js","https://github.com/nathancahill/skeleton-tabs","/assets/js/skeleton-tabs.js",0,0],
	["js_plotly","Plotly.js","https://plot.ly/plotly-js-scientific-d3-charting-library/","https://cdn.plot.ly/plotly-latest.min.js",0,1],
	["js_mathjax_html","MathJax w/ HTML","https://www.mathjax.org/","https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-MML-AM_CHTML",0,1],
	["js_mathjax_svg","MathJax w/ SVG","https://www.mathjax.org/","https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-AMS-MML_SVG",0,1],
	["js_markedjs","marked.js","https://github.com/chjj/marked","/assets/js/marked.js",0,1],
	["js_phaserio","phaser.io","https://phaser.io/","/assets/js/phaser.min.js",0,0],
	["js_numeric_javascript","Numeric Javascript","http://www.numericjs.com/","/assets/js/numeric-1.2.6.min.js",0,0],
	["js_mathjs","mathjs","http://mathjs.org/index.html","https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.16.3/math.min.js",0,0]
];
?>
