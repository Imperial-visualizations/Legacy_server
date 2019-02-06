  var algObjs = {};

  function nextName() {
    //generate name for the algObj being created
    names = ['Albert','Beatriz','Connor','Diana','Elvis','Fiona','Gondor','Helga','Igor','Joanna','Kamath','Lucille','Łukasz','Mortimer','Norma','Oromis','Patricia','WhatisanameforQ?','Rose','Sandor','Tarya','Urgal','Valor','Wendy','Xavier','Yeti','Zoltan']
    var name = names[((objcounter-1) % names.length)];
    return name;
  }
  function getRandomInt() {
    min = -5;
    max = 6;
    return Math.floor(Math.random() * (max - min)) + min;
  }
  function log(txt) {
    $("#panelHeadWrapper").html($("#panelHeadWrapper").html()+txt+"<br>");
    $("#panelHeadWrapper").animate({ scrollTop: $('#panelHeadWrapper').prop("scrollHeight")}, 200);
  }
  $(document).ready(function() {
    console.log("Document ready!")
    log("<blue>Click to select.</blue>");
    log("<blue>Click again to deselect.</blue>");
    log("<blue>Double click to edit.</blue>");
    if(sessionStorage.lastSaved != undefined) {
      console.log("there is a saved state... retrieving,",sessionStorage);
      var retrieveAlgObjs = JSON.parse(sessionStorage.getItem("algObjsSaved"));
      objcounter = JSON.parse(sessionStorage.getItem("algObjsCounterSaved"));
      function rebuildAlgObj(obj) {
        // rebuild algObj from its saved, stringified state
        var rebuild = undefined;
        if(obj.hasOwnProperty("usrPos")) {
          //it's a point
          rebuild = new Point(new Vector(obj.usrPos.x,obj.usrPos.y,obj.usrPos.z));
        }
        else if(obj.hasOwnProperty('usrDir')) {
          //it's a line
          rebuild = new Line(new Vector(obj.usrDir.x,obj.usrDir.y,obj.usrDir.z), new Vector(obj.usrOff.x,obj.usrOff.y,obj.usrOff.z));
        }
        else if(obj.hasOwnProperty('usrNormal')) {
          //it's a Plane
          rebuild = new Plane(new Vector(obj.usrNormal.x,obj.usrNormal.y,obj.usrNormal.z), new Vector(obj.usrOff.x,obj.usrOff.y,obj.usrOff.z));
        }
        else {
          //we don't know what it is
          //throw new Error("Rebuild unsuccesful");
          rebuild = obj;
        }
        if(obj.hasOwnProperty('name')) {
          rebuild.name = obj.name;
        }
        return rebuild;
      }
      rebuildDict = {};
      for(idx in retrieveAlgObjs) {
        //rebuild everything
        var newobj = rebuildAlgObj(retrieveAlgObjs[idx]);
        rebuildDict[newobj.id] = newobj; //add this object to the new algObj dictionary
        plot.addPlotObj(rebuildDict[newobj.id]); //add this object to the plot
      }
      algObjs = rebuildDict;
      redisplay();
    } else {
      log("No saved state found.")
      console.log("no saved state... defaulting");
    }
    redisplay();
    $("#addPoint").on('click',function() {
      var newPoint = new Point(new Vector(getRandomInt(),getRandomInt(),getRandomInt()));
      newPoint.name = nextName(); //generate name
      algObjs[newPoint.id] = newPoint; //ad to the dict
      plot.addPlotObj(algObjs[newPoint.id]); //add to plot
      log(algObjs[newPoint.id].toString()+" added.");
      //expand the toolbox
      $("#EditorFor"+newPoint.id).slideDown(200);
      $("#EditorFor"+newPoint.id).addClass("expanded");
      $("#NameOf"+newPoint.id).focus();
      redisplay();
    });
    $("#addLine").on('click',function(){
      var newLine = new Line(new Vector(getRandomInt(),getRandomInt(),getRandomInt()),new Vector(getRandomInt(),getRandomInt(),getRandomInt()));
      newLine.name = nextName(); //generate name for this line
      algObjs[newLine.id] = newLine; //add to dictionary
      plot.addPlotObj(algObjs[newLine.id]); //add to plot
      log(algObjs[newLine.id].toString()+" added.");
      //expand toolbopx
      $("#EditorFor"+newLine.id).slideDown(200);
      $("#EditorFor"+newLine.id).addClass("expanded");
      $("#NameOf"+newLine.id).focus();
      redisplay(); //redisplay panel
    });
    $("#addPlane").on('click',function(){
      var newPlane = new Plane(new Vector(getRandomInt(),getRandomInt(),getRandomInt()), new Vector(getRandomInt(),getRandomInt(),getRandomInt()));
      newPlane.name = nextName(); //get name
      algObjs[newPlane.id] = newPlane; //add to dict
      plot.addPlotObj(algObjs[newPlane.id]); //plot
      //we could call addAlgObj(algObjs[newid]) but it's obsolete
      log(algObjs[newPlane.id].toString()+" added.");
      $("#EditorFor"+newPlane.id).slideDown(200);
      $("#EditorFor"+newPlane.id).addClass("expanded");
      $("#NameOf"+newPlane.id).focus();
      redisplay(); //redisplay panel
    });
    $("#intersect").on('click',function(){
      if($("#intersect").hasClass("active")) {
        log("Finding intersection....");
        var selectedObjs = getSelectedAlgObjs();
        console.log("interect selected objs: ",selectedObjs);
        try {
          var newobj = intersectList(selectedObjs);
          var newid = newobj.id;
          algObjs[newid] = newobj;
          plot.addPlotObj(algObjs[newid]); //add to plot too
          log("Results displayed.");
        }
        catch(err) {
          console.log(err);
          log("<red>No intersections found.</red>");
        }
        finally {
          plot.unHighlightPlotObjs();
          redisplay(); //redisplay panel
        }
      }
    });
    function purgeAlgObj(algObj) {
      /* Removes an algObj from everywhere: the dictionary, The panel
      plot etc. */
      console.log("purging algObj:",algObj);
      $( "#"+i ).parent().remove(); //from panel
      delete algObjs[algObj.id]; //from dictionary
      plot.deletePlotObj(algObj); //from plot
    }
    $("#clear").on('click',function() {
      for (i in algObjs) {
        console.log("idx: ", i, ", object: ", algObjs[i].toString());
        purgeAlgObj(algObjs[i]);
      }
      redisplay();
      //To display the message (press button to add points etc..)
    });
    $("#delete").on('click',function(){
      if($(this).hasClass("active")) {
      console.log(algObjs);
      var selectedObjs = getSelectedAlgObjs();
      console.log("delete clicked, purging algObjs: ", selectedObjs);
      for(var idx=0;idx<selectedObjs.length;idx++) {
        purgeAlgObj(selectedObjs[idx]);
      }
      plot.unHighlightPlotObjs();
      redisplay();
    }
  });
    $("#save").on('click',save);
  });
  function getSelectedAlgObjs() {
    /* Retrieve a list of selected items in the panel.
    It compares the ids of selected labels with entries of
    'dictionary'. */
    var selectedObjs = [];
    $("#panelItemsWrapper>item>label.selected").each(
      function() {
        selectedObjs.push(algObjs[$(this)[0].id]);
      }
    )
    return selectedObjs;
  }
  function save(){
    console.log("save: current state", sessionStorage)
    sessionStorage.setItem("algObjsSaved", JSON.stringify(algObjs));
    sessionStorage.setItem("algObjsCounterSaved", JSON.stringify(objcounter));
    var currentdate = new Date();
    var datetime = "" + currentdate.getDate() + "/"
    + (currentdate.getMonth()+1)  + "/"
    + currentdate.getFullYear() + " @ "
    + currentdate.getHours() + ":"
    + currentdate.getMinutes() + ":"
    + currentdate.getSeconds();
    sessionStorage.lastSaved = datetime;

    log("<blue>Last Saved: "+sessionStorage.lastSaved+"</blue>");
  }
  function saveToObject(id){
    var changes = 0;
    var dontClose = false;
    var logMessage = "Updated: ";
    var thisObject = $("#"+id);
    if(algObjs[id].name != $("#NameOf"+id).val()){
      //changing name if it is different that it is now
      changes += 1;
      algObjs[id].name = String($("#NameOf"+id).val()); //change name
      $("#"+id).text(algObjs[id].toString());
    }
    logMessage += algObjs[id].toString()+" ";

    if(algObjs[id] instanceof Point){
      //retrieve user data
      x = parseFloat($("#"+id+"PX").val());
      y = parseFloat($("#"+id+"PY").val());
      z = parseFloat($("#"+id+"PZ").val());
      newPos = new Vector(x,y,z); //Point.assignPos takes Vector input
      if(newPos.isEqualTo(algObjs[id].pos)){
        // If no change is made do nothing
        // to save CPU time
      } else {
        changes += 1;
        algObjs[id].assignPos(newPos);
        plot.refreshPlotObj(algObjs[id]); //this re-adds the object to the plot
        //necessary because plot does not keep reference to original objects;
        //after changed the object has to call .goify(..) again and pass
        //to fastPlotHandler
        logMessage += ("<br><b>r</b>=("+x+","+y+","+z+")");
      }

    } else if(algObjs[id] instanceof Line){

      dirx = parseFloat($("#"+id+"DX").val());
      diry = parseFloat($("#"+id+"DY").val());
      dirz = parseFloat($("#"+id+"DZ").val());
      offx = parseFloat($("#"+id+"OX").val());
      offy = parseFloat($("#"+id+"OY").val());
      offz = parseFloat($("#"+id+"OZ").val());

      try {
        newDir = new Vector(dirx,diry,dirz);
        newOff = new Vector(offx,offy,offz);
        if(newDir.isEqualTo(algObjs[id].dir) && newOff.isEqualTo(algObjs[id].off)){
          // If no change is made do nothing
          // to save CPU time
        }else{
          changes += 1;
          algObjs[id].assignDir(newDir);
          algObjs[id].assignOff(newOff);
          plot.refreshPlotObj(algObjs[id]); //refresh the Line on the plot
          //see note for addPoint
          logMessage += ("<br><b>r</b>=("+offx+","+offy+","+offz+")+µ("+dirx+","+diry+","+dirz+")");
        }
      } catch(err) {
        console.log(err); //it is only assignDir that can throw, at it is going to be argument error
        log("<red>ERROR: "+err.message+"<br>The Direction of "+algObjs[id].toString()+" can't be (0,0,0)!</red>");
        var dontClose = true; //don't close the
      }

    } else if(algObjs[id] instanceof Plane){

      normalx = parseFloat($("#"+id+"NX").val());
      normaly = parseFloat($("#"+id+"NY").val());
      normalz = parseFloat($("#"+id+"NZ").val());
      offx = parseFloat($("#"+id+"OX").val());
      offy = parseFloat($("#"+id+"OY").val());
      offz = parseFloat($("#"+id+"OZ").val());

      try {
        newNormal = new Vector(normalx,normaly,normalz);
        newOff = new Vector(offx,offy,offz);
        if(newNormal.isEqualTo(algObjs[id].normal) && newOff.isEqualTo(algObjs[id].off)){
          // If no change is made do nothing
          // to save CPU time
        }else{
          changes += 1;
          algObjs[id].assignNormal(newNormal);
          algObjs[id].assignOff(newOff);
          plot.refreshPlotObj(algObjs[id]); //refresh the Plane on the plot
          //see note for saving to point
          logMessage += ("<br>("+normalx+","+normaly+","+normalz+")•(<b>r</b>-("+offx+","+offy+","+offz+"))=0");
        }
      } catch(err) {
        console.log(err);
        log("<red>ERROR: "+err.message+"<br>The Normal of "+algObjs[id].toString()+" can't be (0,0,0)!</red>");
        var dontClose = true;
      }

    }else{
      console.log("ERROR: the object "+id+" can't be accessed.");
    }
    if(dontClose){
      //don't close the panel
      $("#panelItemsWrapper").scrollTop($("#EditorFor"+id).position().top-80);
    } else{
      if(changes > 0){
        $("#EditorFor"+id).slideUp(100);
        //redrawPlot();
        log(logMessage);
      }else{
        $("#EditorFor"+id).slideUp(600);
      }
      $("#EditorFor"+id).removeClass("expanded");
    }
  }
  function itemsAddEventListener() {
    $("#panelItemsWrapper>item>span").each(function(index){
      //these are the 'Eyes'
      $(this).off();
      $(this).on('click',function(event){
        //click on the eye - show/hide algObjs
        $(this).toggleClass("active");
        if($(this).hasClass("active")) {
          var activeId = $(this)[0].firstChild.id.replace('Eye','');
          plot.showTraces([activeId]); //show what was clicked to be shown
        }
        else {
          var deactiveId = $(this)[0].firstChild.id.replace('Eye','');
          plot.hideTraces([deactiveId]); //hide what was clicked to be hidden
        }
        event.preventDefault();
      });
    });
    $("#panelItemsWrapper>item>label").each(function(index) {
      //the labels, that contain the names of algObjs
      $(this).off();
      $(this).on('click',function(event){
        $(this).toggleClass("selected");
        var selectedObjs = getSelectedAlgObjs();
        //highlighting
        //commented out for the presentation

        if(selectedObjs.length != 0){
          //unhighlight and highlight again
          plot.unHighlightTraces();
          plot.highlightPlotObjs(selectedObjs);
        } else {
          //nothing to highlight, so remove highlights
          plot.unHighlightTraces();
        }

        //delete button
        if(selectedObjs.length != 0){
          $("#delete").addClass("active");
          $("#delete").prop("disabled",false);
        } else {
          $("#delete").prop("disabled",true);
          $("#delete").removeClass("active");
        }
        //intersect button
        if(selectedObjs.length>1) {
          $("#intersect").addClass("active");
          $("#delete").prop("disabled",false);
        }else{
          $("#delete").prop("disabled",true);
          $("#intersect").removeClass("active");
        }
        event.stopPropagation();
        event.preventDefault();
      });
      $(this).on('dblclick',function(event) {
        id = $(this).attr("id");
        console.log("double click on ",id)
        if($("#EditorFor"+id).hasClass("expanded")){
          //update the object with the value in the input elements
          saveToObject(id);
        }else{
          //update the value in the input elements with object
          $("#NameOf"+id).val(algObjs[id].name);
          if(algObjs[id] instanceof Point){
            $("#"+id+"PX").val(algObjs[id].usrPos.x);
            $("#"+id+"PY").val(algObjs[id].usrPos.y);
            $("#"+id+"PZ").val(algObjs[id].usrPos.z);
          }else if(algObjs[id] instanceof Line){
            $("#"+id+"DX").val(algObjs[id].usrDir.x);
            $("#"+id+"DY").val(algObjs[id].usrDir.y);
            $("#"+id+"DZ").val(algObjs[id].usrDir.z);
            $("#"+id+"OX").val(algObjs[id].usrOff.x);
            $("#"+id+"OY").val(algObjs[id].usrOff.y);
            $("#"+id+"OZ").val(algObjs[id].usrOff.z);
          }else if(algObjs[id] instanceof Plane){
            $("#"+id+"NX").val(algObjs[id].usrNormal.x);
            $("#"+id+"NY").val(algObjs[id].usrNormal.y);
            $("#"+id+"NZ").val(algObjs[id].usrNormal.z);
            $("#"+id+"OX").val(algObjs[id].usrOff.x);
            $("#"+id+"OY").val(algObjs[id].usrOff.y);
            $("#"+id+"OZ").val(algObjs[id].usrOff.z);
          }else{
            console.log("ERROR: the object "+id+" can't be accessed.");
          }
          $("#EditorFor"+id).slideToggle(200);
          $("#panelItemsWrapper>item>label").each(function(){
            // "this" in here is not the same as the "this" outside,
            // so can't use "id" but have to use $(this).attr("id")
            $(this).removeClass("selected");
            if($("#EditorFor"+$(this).attr("id")).hasClass("expanded")){
              saveToObject($(this).attr("id"));
            }
          });
          $("#EditorFor"+id).toggleClass("expanded");
        }
        event.stopPropagation();
        event.preventDefault();
      });
    });
    $("#panelItemsWrapper>itemEditor").each(function(index){
      $(this).off();
      $(this).on('click',function(event){
        event.stopPropagation();
        event.preventDefault();
      });
    });
    $("#panelItemsWrapper").each(function(index){
      $(this).off();
      $(this).on('click',function(event){
        $("#panelItemsWrapper>item>label").each(function(index){
          $(this).removeClass("selected");
          if($("#EditorFor"+$(this).attr("id")).hasClass("expanded")){
            saveToObject($(this).attr("id"));
          }
        });
        plot.unHighlightTraces();
        $("#intersect").removeClass("active");
        $("#delete").removeClass("active");
        event.stopPropagation();
        event.preventDefault();
      });
    });
    $("itemeditor input").each(function(){
      $(this).off();
      $(this).on('keypress',function(e){
        if(e.which == 13 || e.originalEvent.keyCode == 13){
          id = $(this).attr("id");
          if($(this).hasClass("itemNameInput")){
            id = id.slice(6, id.length);
          }else{
            id = id.slice(0, -2);
          }
          console.log("intemeditor input", id);
          saveToObject(id);
          e.stopPropagation();
          e.preventDefault();
        }
      });
    });
  }
  function algObjToPanel(object){
    //console.log("AlgObj with id "+object.id+", ", object.toString());
    $("#panelItemsWrapper>p").remove();
    $("#panelItemsWrapper").append("<item class='"+object.type+"'><span class='active'><i id='"+object.id+"Eye' class='fa fa-eye' aria-hidden='true'></i></span><label id='"+object.id+"'>"+object.toString()+"</label></item>");
    if(object instanceof Point){
      $("#panelItemsWrapper").append('<itemEditor id="EditorFor'+object.id+'" style="display: none;"><input class="itemNameInput" id="NameOf'+object.id+'" value="'+object.name+'"><label>Position</label><span class="inputWrapper">x:<input id="'+object.id+'PX" value="'+object.pos.x+'"></span><span class="inputWrapper">y:<input id="'+object.id+'PY" value="'+object.pos.y+'"></span><span class="inputWrapper">z:<input id="'+object.id+'PZ" value="'+object.pos.z+'"></span></itemEditor>');
    }else if(object instanceof Line){
      $("#panelItemsWrapper").append('<itemEditor id="EditorFor'+object.id+'" style="display: none;"><input class="itemNameInput" id="NameOf'+object.id+'" value="'+object.name+'"><label>Direction</label><span class="inputWrapper">x:<input id="'+object.id+'DX" value="'+object.dir.x+'"></span><span class="inputWrapper">y:<input id="'+object.id+'DY" value="'+object.dir.y+'"></span><span class="inputWrapper">z:<input id="'+object.id+'DZ" value="'+object.dir.z+'"></span><label>Offset</label><span class="inputWrapper">x:<input id="'+object.id+'OX" value="'+object.off.x+'"></span><span class="inputWrapper">y:<input id="'+object.id+'OY" value="'+object.off.y+'"></span><span class="inputWrapper">z:<input id="'+object.id+'OZ" value="'+object.off.z+'"></span></itemEditor>');

    }else if(object instanceof Plane){
      $("#panelItemsWrapper").append('<itemEditor id="EditorFor'+object.id+'" style="display: none;"><input class="itemNameInput" id="NameOf'+object.id+'" value="'+object.name+'"><label>Normal</label><span class="inputWrapper">x:<input id="'+object.id+'NX" value="'+object.normal.x+'"></span><span class="inputWrapper">y:<input id="'+object.id+'NY" value="'+object.normal.y+'"></span><span class="inputWrapper">z:<input id="'+object.id+'NZ" value="'+object.normal.z+'"></span><label>Offset</label><span class="inputWrapper">x:<input id="'+object.id+'OX" value="'+object.off.x+'"></span><span class="inputWrapper">y:<input id="'+object.id+'OY" value="'+object.off.y+'"></span><span class="inputWrapper">z:<input id="'+object.id+'OZ" value="'+object.off.z+'"></span></itemEditor>');

    }else{
      console.log("Error: Invalid input type for algObjToPanel().");
    }

    itemsAddEventListener();
  }
  function redisplay(){
    console.log("redisplaying panel...", algObjs)
    if(Object.keys(algObjs).length == 0){
      $("#panelItemsWrapper").html('<p ><br>Press the <i class="fa fa-plus fa-fw" aria-hidden="true"></i> buttons to add point, line or plane.</p>');
    }
    else {
      $("#panelItemsWrapper").html("");
      for (i in algObjs) {
        //console.log("redisplay: ", algObjs[i]);
        algObjToPanel(algObjs[i]);
      }
    }
    //console.log("redisplaying graph...")
    //redrawPlot();
  }
  