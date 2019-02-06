  var layout = {
    scene: {
      xaxis: {
        range: [-10,10]
      },
      yaxis: {
        range: [-10,10]
      },
      zaxis: {
        range: [-10,10]
      },
      camera: {
        up: {
          x: 0,
          y: 0,
          z: 1
        },
        eye: {
          x: -1.7428,
          y: 1.0707,
          z: 0.7100
        }
      },
      aspectratio: {x: 1, y: 1, z: 1},
    },
    showlegend: false,
    margin: {l:0,r:0,b:0,t:0}
  };
  var plot = null;
  $('#canvasWrapper').ready(function() {
    plot = new fastPlotHandler('canvasWrapper');
    plot.init();
    plot.setLayout(layout);
  });