
var ourRequest = new XMLHttpRequest();
ourRequest.open('GET','https://rawgit.com/Blaze23/imperialvisualize/master/cyclo.JSON')
 
var xy = {
	x0: 0,
	y0: 0,
    data: []
}

var vars = {
    B: 4,
    E: 40,
    M: 3
}

var slides = {
    intface: $("#interface"),
    BInput: $("input#E"),
    EInput: $("input#B")
}

var is_paused = true;

var counter_x0 = 0;
var counter_x0_lim = 1000;
var counter_y0 = 0;
var counter_y0_lim = 1000;

//var x0 = 0,
// 	y0 = 0 ;



function plot(scatter0, layout) {
	Plotly.newPlot("particle", {data: [scatter0], traces: [0], layout: layout}); 
	 } 
	  




function update() { 
	 if (!is_paused) {
		counter_x0++; 
		if (counter_x0 === counter_x0_lim) {
			counter_x0 = 0;
		}
		counter_y0++; 
		if (counter_y0 === counter_y0_lim) {
			counter_y0 = 0;
		}
		Plotly.animate("particle", {data: [{y: xy.y0.slice(0, counter_y0), x: xy.x0.slice(0, counter_x0)}], traces: [0]}, {transition: {duration: 0}, frame: {redraw: false, duration: 0}}); 
		requestAnimationFrame(update); 
	}

}
 
function onToggleRun() { 
	is_paused = !is_paused;
	document.getElementById('run').value = (is_paused) ? 'Play':'Pause';
	requestAnimationFrame(update);
}
function onReset() { 
	 counter_x0 = 0;
	 counter_y0 = 0;

     if (!is_paused) { 
            Plotly.animate("particle", {data: [{y: xy.y0.slice(0, counter_y0), x: xy.x0.slice(0, counter_x0)}], traces: [0]}, {transition: {duration: 0}, frame: {redraw: false, duration: 0}}); 
    } 
} 

    






ourRequest.onload=function(){

	var data = JSON.parse(ourRequest.responseText);



	//all the plotly stuff here or whatever you wanna do with the data 
    
    xy.data = data[0]['B_' + String(vars.B)][0]['E_' + String(vars.E)][0]['Mass' + String(vars.M)];
    
    
    console.log(vars.B.type);

    xy.x0 = xy.data[0];
    xy.y0 = xy.data[1];
    



//	var scatter0 = {x: xy.x0, y: xy.y0, mode: "lines", type: "scatter", line: {width: 1, color: "blue"}, name: "sine"};
//	var layout = {xaxis: {range: [-8, 8], title: "x"}, yaxis: {range: [-8, 8], title: "y"}, title: "Cyclotron"};

	var scatter0 = {name: "Particle", y: xy.y0, mode: "lines", type: "scatter", x: xy.x0, line: {width: 2, color: "blue"}};
	var layout = {title: "Charged Particle in Cyclotron", yaxis: {range: [-18.299527668192489, 14.841221423457796], title: "y"}, xaxis: {range: [-18.100264778304414, 16.560289735319614], title: "x"}};
	
	

	plot(scatter0, layout);
	requestAnimationFrame(update);
    
    $('#B').on('change', function(){
        vars.B = $(this).val();
        xy.data = data[0]['B_' + String(vars.B)][0]['E_' + String(vars.E)][0]['Mass' + String(vars.M)];
        xy.x0 = xy.data[0];
        xy.y0 = xy.data[1];
        
        var scatter0 = {name: "Particle", y: xy.y0, mode: "lines", type: "scatter", x: xy.x0, line: {width: 2, color: "blue"}};
        
        Plotly.restyle(plot, scatter0)
    });
                      
    $('#E').on('change', function(){
        vars.E = $(this).val();
        xy.data = data[0]['B_' + String(vars.B)][0]['E_' + String(vars.E)][0]['Mass' + String(vars.M)];
        xy.x0 = xy.data[0];
        xy.y0 = xy.data[1];
        
        var scatter0 = {name: "Particle", y: xy.y0, mode: "lines", type: "scatter", x: xy.x0, line: {width: 2, color: "blue"}};
        
        Plotly.restyle(plot, scatter0)

	});
    
    $('#M').on('change', function(){
        vars.M = $(this).val();
        xy.data = data[0]['B_' + String(vars.B)][0]['E_' + String(vars.E)][0]['Mass' + String(vars.M)];
        xy.x0 = xy.data[0];
        xy.y0 = xy.data[1];
        
        var scatter0 = {name: "Particle", y: xy.y0, mode: "lines", type: "scatter", x: xy.x0, line: {width: 2, color: "blue"}};
        
        Plotly.restyle(plot, scatter0)

	});

    
}
                                            
                                        
ourRequest.send();


   