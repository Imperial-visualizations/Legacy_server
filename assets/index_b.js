$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().replace(/\'/g, "").indexOf(arg.toUpperCase()) >= 0;
    };
});

        var toggleMenu = anime({
          targets: '#menu .bar',
          translateX: -100,
          delay: function(el, i, l) { return i * 100; },
          duration: 50,
          autoplay: false,
          easing: 'easeInOutQuint',
          complete: function(anim) {
            $("#menu").toggleClass("opened");
          }
        });

        var toggleDel = anime({
          targets: '#menu .del',
          translateX: {
            value: [-150, 0],
            duration: 200,
            delay: 100,
            easing: 'easeInOutBack'
          },
          rotate: {
            value: function(el, i, l) { return (1-i*2)*45; },
            delay: 150,
            duration: 150,
            easing: 'easeInOutBack'
          },
          autoplay: false
        });

        var toggleMenuItems = anime({
          targets: '.menu-item',
          translateX:  [-150, 0],
          duration: 200,
          delay: function(el, i, l) { return i * 100 + 100; },
          easing: 'easeInOutBack',
          autoplay: false
        });

        var searchOpen = anime.timeline({autoplay: false,complete:function(){$("#magnifier").toggleClass("closed");}});
        searchOpen.add({
            targets: '#magnifier',
            backgroundColor: ["#002147","#000000"],
            duration: 100,
            easing: 'easeInOutQuad'
        }).add({
            targets: '#searchBar',
            opacity: [0,1],
            width: [40,300],
            duration: 100,
            offset: 0,
            easing: 'easeInOutQuad'
        }).add({
            targets: '#magnifier',
            color: ["#fff","#aaa"],
            duration: 100,
            offset: 100,
            easing: 'easeInOutQuad'
        });

        $("#menu").on('click',function(){
            if($(this).hasClass("opened")){
                toggleMenu.play();
                toggleMenu.reverse();
                toggleDel.play();
                toggleDel.reverse();
                toggleMenuItems.play();
                toggleMenuItems.reverse();
            }else{
                toggleMenu.play();
                toggleDel.play();
                toggleMenuItems.play();
            }
            
        });

        function search(query){
            // for (Visual in Visualisations) {
            //     if( Visualisations[Visual].doneBy.indexOf(query) > -1 )
            //     $("#content").append('<a href="#" id="'+Visual+'" class="card '+toHTML(Visualisations[Visual].categories,"class")+'"><span class="cardTitle">'+Visualisations[Visual].displayName+'</span><br><span class="cardDoneBy">done by <em>'+toHTML(Visualisations[Visual].doneBy,"list")+'</em></span><img class="cardBackground" src="./assets/_2Dtwobodycollisionwithonestationary.png"><span class="categories">'+toHTML(Visualisations[Visual].categories,"span")+'</span></a>');
            // }
            query = query.trim();
            query = query.replace(/\'/g, "");
            console.log(query);
            $(".card").each(function(){
                    $(this).hide();
            });
            $(".card:contains('"+query+"')").each(function(){
                    $(this).show();
            });
            $('.grid').masonry('layout');

            // var i = 0
            // $(".card").each(function(){
            //         $(this).hide("fast");
            //     if($(this).hasClass(query)){
            //         $(this).show("fast");
            //         i += 1;
            //     }else{
            //         $(this).hide("fast");
            //     }
            // });
            // if(i == 0){
            //     $(".card").show("fast");
            // }
        }
        $(document).ready(function(){
            if(window.location.hash) {
                search(window.location.hash.replace("#", ""));
                $("#searchBar1").val(window.location.hash.replace("#", ""));
                $("#searchBar2").val(window.location.hash.replace("#", ""));
                $("#searchBar2Reset").addClass("show");
            } else {
            }
              $('.grid').masonry({
                // options
                itemSelector: '.card',
                // use element for option
                columnWidth: '.grid-sizer',
                gutter: '.gutter-sizer',
                percentPosition: true
              });
              $('.grid').imagesLoaded().progress( function() {
                $('.grid').masonry('layout');
              });
        });
        $(".courses").on('click',function(e){
            search($(this).attr("href").replace("#", ""));
            $("#searchBar1").val($(this).attr("href").replace("#", ""));
            $("#searchBar2").val($(this).attr("href").replace("#", ""));
            $("#searchBar2Reset").addClass("show");
        });
        $("#magnifier").on('click',function(e){
            if($("#searchBar").val()==""){
                if(!$("#magnifier").hasClass("closed")){
                    searchOpen.restart();
                    searchOpen.reverse();
                    $("#searchBar").blur();
                    $(".card").show();
                    $('.grid').masonry('layout');
                }else{
                    searchOpen.restart();
                    $("#searchBar").focus();
                }
            }else{
                if(!$("#magnifier").hasClass("closed")){
                    search($("#searchBar").val());
                    window.location.hash = "#"+$("#searchBar").val();
                    $("#searchBar").focus();
                }else{
                    searchOpen.restart();
                    $("#searchBar").focus();
                }
            }
            e.preventDefault();
            e.stopPropagation();
        });
        $("#magnifier2").on('click',function(e){
            if($("#searchBar2").val()==""){
                $("#searchBar2").blur();
                $(".card").show();
                $('.grid').masonry('layout');
                window.location.hash = "";
            }else{
                search($("#searchBar2").val());
                window.location.hash = "#"+$("#searchBar2").val();
            }
            e.preventDefault();
            e.stopPropagation();
        });

        $("#searchBar,#searchBar2").on('click',function(e){
            e.stopPropagation();
        });

        $("#searchBar").keydown(function (e) {
          if (e.keyCode == 13) {
            $("#magnifier").click();
          }
        });
        $("#searchBar2").keydown(function (e) {
          if (e.keyCode == 13) {
            $("#magnifier2").click();
          }
        });
        $("#searchBar2").keyup(function (e) {
          if($(this).val() != ""){
            $("#searchBar2Reset").addClass("show");
          }else{
            $("#searchBar2Reset").removeClass("show");
          }
        });
        $("#searchBar2Reset").click(function (e) {
            $("#searchBar2").val("");
            $(".card").show();
            $('.grid').masonry('layout');
            window.location.hash = "";
            $("#searchBar2Reset").removeClass("show");
            e.preventDefault();
            e.stopPropagation();
        });
        $("#container").click(function (e) {
                if(!$("#magnifier").hasClass("closed")){
                    searchOpen.restart();
                    searchOpen.reverse();
                    e.preventDefault();
                    e.stopPropagation();
                }else{
                }
        });
        $(".about").on('click',function(){

        });