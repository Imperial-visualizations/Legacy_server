var layout = {
  width: 900,
  height: 450,
  autosize: true,
  scene: {
    xaxis: {range: [-1.5, 1.5], autorange:false, zeroline:false},
    yaxis: {range: [-1.5, 1.5], autorange:false, zeroline:false},
    zaxis: {range: [0, 1.5], autorange:false, zeroline:false},
    aspectmode: 'cube',
    camera: {center: {x:0,y:0,z:0},eye: {x: 1.5,y: -1.5,z: 0.8}}
  },
  margin: {},
          legend: {x:0.75,y:0.75,z:1,
            orientation: 'v',
            fontsize: 20
        },
        font: {
            size: 14,
            color: '#003E74',
            weight: 700
        },
    
};

var frames, addOn;
var animateIndex = 0, animateLimit = 0;
var duration = 50;
var isPaused = false;
var stops;
var idName;


function initAnimation(sliderName, allFrames, extra=[], layout={}, setDuration = 50, stopValues=[0, 0]) {
    idName = sliderName;
    duration = setDuration;
    frames = allFrames;
    animateLimit = frames.length;
    addOn = extra;
    stops = stopValues;
    isPaused = true;
    animateIndex = 0;
    var data = [];
    for (var i = 0, n = frames[i].length; i < n; ++i) {
        data.push(frames[animateIndex][i]);
    }
    for (var i = 0, n = addOn.length; i < n; ++i){
        data.push(addOn[i]);
    }
    Plotly.newPlot('graph', data = data, layout = layout);
    reset();
}

function reset() {
    isPaused = true;
    animateIndex = 0;
    historyPlot(animateIndex);
    document.getElementById('playPause').value = (isPaused) ? "Play":"Pause";
    resetSlider();
    
    return;
}

function historyPlot(index) {
    animateIndex = index;
    var data = [];
    for (var i = 0, n = frames[index].length; i < n; ++i) {
        data.push(frames[index][i]);
    }
    Plotly.animate(
        'graph',
        {data: data},
        {
            fromcurrent: true,
            transition: {duration: 0,},
            frame: {duration: 0, redraw: false,},
        }
    );
    isPaused = true;
    document.getElementById('playPause').value = (isPaused) ? "Play":"Pause";
    return;
}

function update() {
    animateIndex++;
    if (animateIndex === animateLimit) {
        isPaused = true;
        document.getElementById('playPause').value = (isPaused) ? "Play":"Pause";
        return;
    }
    if (!isPaused) {
        data = [];
        for (var i = 0, n = frames[1].length; i < n; ++i) { //this was basically frames[1].length
            data.push(frames[animateIndex][i]);
        }
        Plotly.animate(
            'graph',
            {data: data},
            {
                fromcurrent: true,
                transition: {duration: duration,},
                frame: {duration: duration, redraw: false,},
            }
        );
        pauseComp(duration + 1);
        requestAnimationFrame(update);
        resetSlider();
        if (animateIndex === stops[0] || animateIndex === stops[1]){
            isPaused = !isPaused;
            document.getElementById('playPause').value = (isPaused) ? "Play":"Pause";
        }
    }
    return;
}

function pauseComp(ms) {
    ms +=new Date().getTime();
    while (new Date() < ms){}
    return;
}

function resetSlider() {
    $(idName).val(animateIndex);
    $(idName + "Display").text(animateIndex);
    return;
}

function startAnimation () {
    if (animateIndex < animateLimit){
        isPaused = !isPaused;
        document.getElementById('playPause').value = (isPaused) ? "Play":"Pause";
        requestAnimationFrame(update);
    }
    return;
}


    function getObjKeys(obj) {
        return Object.keys(obj);
    }
    /**
    * Return the keys of an Object as integers
    * @param {Object} obj
    * @returns {array}
    */
    function getObjKeysAsInts(obj) {
        return Object.keys(obj).map(Number);
    }
    /**
    * Return the values of an Object
    * @param {Object} obj
    * @returns {array}
    */
    function getObjValues(obj) {
        return Object.keys(obj).map(function(key) {
            return obj[key];
        });
    }

function updatePlot(myData) {
    var update2 = {},
            plotData = myData;
			
        for (var trace = 0; trace < plotData.length - 1; trace++) {
            update2[trace] = {
                x: plotData[trace].x,
                y: plotData[trace].y,
                z: plotData[trace].z,
                opacity: 1
            };
        }
        console.log(update2)
        Plotly.animate(div="graph", {
            data: getObjValues(update2),
            traces: getObjKeysAsInts(update2),
            layout: layout
        }, {
            transition: {duration: 0},
            frame: {duration: 0, redraw: false}
        });
}

// Import data in json file as "frames" variable (same data structure as initially output in Python)

    var ourRequest = new XMLHttpRequest();

    ourRequest.open('GET','https://rawgit.com/amna-askari/JSONfilesforVisualisations/master/BiotAnimate.JSON')

    ourRequest.onload=function(){
        
        var data = JSON.parse(ourRequest.responseText);
        Plotly.newPlot(div='graph',data.Frames[0][0],layout)
//        console.log(data.Frames[0])
        
        //This is so that the play / pause and animation slider features work for the first or default position 
        initAnimation('#animation', data.Frames[0], extra=[], layout=layout, setDuration = 100, stopValues=[11,11])
        $('#animation').on('input', function(){
        p = $(this).val(); 
        updatePlot(data.Frames[0][parseInt(p)])
        });

        //This is so that the play / pause and animation slider features work for the rest of the positions 
        $('#position').on('input', function(){
        k1 = $(this).val();
        var k = parseInt(k1)
        updatePlot(data.Frames[k][0])
        initAnimation('#animation', data.Frames[k], layout=layout, setDuration = 150, stopValues=[11,11])    
            

        $('#animation').on('input', function(){
        m = $(this).val(); 
        updatePlot(data.Frames[k][parseInt(m)])
      
        }); 
        });
        
        };


        ourRequest.send();
