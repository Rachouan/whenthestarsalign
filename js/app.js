window.onload = function() {

  var canvas, context, graph,
    frame = 1000 / 30,
    now,
    delta,
    then = Date.now();

  var posterWidth = 2700,
    posterHeight = 3600;

  var varient = 7365509644349;
  var formUrl = "https://whenthestarsalign.com/cart/add/";
  //var mainurl = "http://rachouanrejeb.be/projects/whenthestarsalign/";
  var mainurl = "";
  var printType = 0;
  var variants = [
    ["7365509644349","7433775153213","7433775218749","7433775284285","7433775153213"]
    ,["7591346012221","7591346044989","7591346077757","7591346110525","7591346143293"]
    ];


  var mainColors = ["#000000", "#000000", "#F38181", "#71C9CE", "#ffffff"],
    mainColor = 0;
  var darkui = false;
  var coloredui = false;

  var legende = 0;
  var legendeStep = 0;
  var legendeSteps = 0;

  var message = "";

  var currentDate;
  var slide = 1;

  var planets = {},
    planetIndex = 0,
    planetSettings = {
      padding: 200,
      orbitPadding: 100,
      astroids: 150,
      radius: 0,
      centerX: 0,
      centerY: 0
    };


  var Debugger = function() {};
  Debugger.log = function(message) {
    try {
      console.log(message);
    } catch (exception) {
      return;
    }
  };

  function canvasSupport() {
    return !!document.createElement('canvas').getContext;
  }


  function init() {
    Debugger.log("De pagina is ingeladen");

    drawPoster();
  }

  function drawPoster() {
    if (!canvasSupport()) {

      Debugger.log("Something went wrong :(!");
      return false;
    }

    canvas = document.getElementById("cnvs");
    context = canvas.getContext("2d");
    canvas.width = posterWidth;
    canvas.height = posterHeight;

    planetSettings.centerX = canvas.width / 2;
    planetSettings.centerY = canvas.height / 2.8;
    planetSettings.radius = canvas.width - planetSettings.padding * 2;

    new Planet("Neptune", "images/planets/neptune.svg", "planet");
    new Planet("Uranus", "images/planets/uranus.svg", "planet");
    new Planet("Saturn", "images/planets/saturn.svg", "planet");
    new Planet("Jupiter", "images/planets/jupiter.svg", "planet");
    new Planet("Belt", "", "belt");
    new Planet("Mars", "images/planets/mars.svg", "planet");
    new Planet("Earth", "images/planets/earth.svg", "planet");
    new Planet("Venus", "images/planets/venus.svg", "planet");
    new Planet("Mercury", "images/planets/mercury.svg", "planet");
    new Planet("Sun", "images/planets/sun.svg", "sun");


    varient = $("input[name=color]:checked").data("varient");

    $("#day,#month,#year").on("change",function (e) {
      setDate();
      updateDate_T6(now);
      run_T6();
      draw();
    });

    $('#Color').val(mainColor);

    $("#message").on("keyup", function(e) {
      message = $(this).val();
      $("#save-message").val(message);
      $(this).removeClass("small");
      if ($(this).val().length > 25) $(this).addClass("small");
      draw();
      $("#Text").val(message);
    });


    $("input,textarea").on("blur", function() {
      $("input,textarea").each(function(key, val) {
        var labels = $(val).parent().find("label");
        $(val).attr("placeholder", $(val).data("placeholder"));
        $(labels).removeClass("open");
      });
    });

    $("input,textarea").on("focus", function(e) {
      $(this).attr("placeholder", "");
      var label = $(this).parent().find("label");
      label.addClass("open");
    });
    $("#date").on("change", function(e) {
      $('#NewDate').val(new Date($(this).val()));
      updateDate_T6(new Date($(this).val()));
      run_T6();
      draw();
    });

    $("input[name=color].color").on("change", function(e) {
      updateColor();
      draw();
      updateForm(formUrl,varient);
    });

    $("input[name=print].print").on("change", function(e) {

      printType = $("input[name=print]:checked").val();
      console.log(printType);
      draw();
      updateForm(formUrl,varient);
    });

    $(".download").on("click", function(e) {
      e.preventDefault();

      var image = null
      if (image == null) {
        loading(true);
        var dataURL = canvas.toDataURL("image/png");
        document.getElementById('hidden_data').value = dataURL;
        var fd = new FormData(document.forms["upload-form"]);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', mainurl+$("form[name=upload-form]").attr("action"), true);

        xhr.upload.onprogress = function(e) {
          loading(true);
          if (e.lengthComputable) {
            var percentComplete = (e.loaded / e.total) * 100;
            $(".preloader .precentage").html(Math.round(percentComplete)+"%");
            console.log(percentComplete);
          }
        };

        xhr.onload = function(e) {
          var url = e.srcElement.response;
          console.log(url);
          $(".preloader .text").html("Adding To Cart");
          $("#Code").val(url);
          if (url) {
            $("#checkout").submit();
          }
        };
        xhr.send(fd);
      }

    });

    $(".buttons-mobile .button").on("click",function(e){
      e.preventDefault();
      switch ($(this).attr("class")) {
        case "button prev":
        slide --;
          break;
        case "button next":
        slide ++;
          break;
        default:
      }


      if(slide < 1){
        slide = 1;
      }
      if(slide > $(".editor .slide").length){
        slide = $(".editor fieldset").length;
      }

      slideshow();
    });

    $(window).on("resize",function (e) {
        slideshow();
    });

    setMessage();
    setColor();
    setDate();
    updateDate_T6(now);
    slideshow();
    run_T6();
    draw();

  }
  function setMessage() {
    var savedMessage = $("#save-message");
    if(savedMessage.val().length > 0){
      message = savedMessage.val();
      $("#message").val(message);
    }
  }
  function setColor() {
    var savedColor = $("#save-color").val();
    var colorcheck = $("input[name=color].color").get(savedColor);
    $(colorcheck).attr('checked', true);
    updateColor();
  }
  function updateColor() {
    mainColor = $("input[name=color].color:checked").val();
    varient = variants[printType][mainColor];
    $('#Color').val(mainColor);
    $("#save-color").val(mainColor);
    darkui = mainColor > 3 ? true : false;
    coloredui = mainColor == 1 ? true : false;
  }
  function setDate() {
    now = new Date(""+$('#month').find(":selected").text() + "-" + $('#day').find(":selected").text()  + "-" + $('#year').find(":selected").text());
    if($('#date').val() != $("#save-date").val()){
      now = new Date($("#save-date").val());
    }
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    $('#day option').filter(function () { return $(this).html() == day; }).attr("selected", "selected");

    var selectMonth = $("#month option").get(now.getMonth());
    $(selectMonth).attr("selected", "selected");

    $('#year option').filter(function () { return $(this).html() == now.getFullYear(); }).attr("selected", "selected");

    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $('#date').val(today);
    $('#save-date').val(today);
    $('#NewDate').val(today);
  }

  function updateForm(url,varient) {
      $("#checkout").attr("action",url+varient);
  }

  function slideshow() {

    $(".buttons-mobile #download").hide();
    if( slide <= 1){
      $(".buttons-mobile .prev").hide();
    }else if(slide >= $(".editor .slide").length){
      $(".buttons-mobile #download").show();
      $(".buttons-mobile .next").hide();
    }else{
      $(".buttons-mobile .prev").show();
      $(".buttons-mobile .next").show();
    }

    var scrollTo = $(".editor .slide:nth-child("+ (slide) +")").position().left;
    $(".wrapper").css({'left': "-"+scrollTo+"px"});
  }

  function draw() {

    legende = 0;
    legendeStep = 0;
    legendeSteps = 0;

    context.fillStyle = mainColors[mainColor];
    context.fillRect(0, 0, canvas.width, canvas.height);
    context.textAlign = "center";

    for (var i in planets) {
      planets[i].draw();
    }
    drawUI();
  }

  function drawUI() {

    var s = addNewlines(message);

    if (darkui) {
      drawString(context, "SOLAR SYSTEM CONSTELLATION ON", planetSettings.centerX, canvas.height - canvas.height / 5, '#000000', 0, "Roboto Slab", 30, 20);
      drawString(context, formatDate(new Date($("#date").val())), planetSettings.centerX, canvas.height - canvas.height / 5.7, '#000000', 0, "Roboto Slab", 50, 20);
      drawString(context, s, planetSettings.centerX, (canvas.height - canvas.height / 6) + 100, '#000000', 0, "Roboto Slab", 50, 10);
    } else {
      drawString(context, "SOLAR SYSTEM CONSTELLATION ON", planetSettings.centerX, canvas.height - canvas.height / 5, '#ffffff', 0, "Roboto Slab", 30, 20);
      drawString(context, formatDate(new Date($("#date").val())), planetSettings.centerX, canvas.height - canvas.height / 5.7, '#ffffff', 0, "Roboto Slab", 50, 20);
      drawString(context, s, planetSettings.centerX, (canvas.height - canvas.height / 6) + 100, '#ffffff', 0, "Roboto Slab", 50, 10);
    }
  }

  function addNewlines(str) {
    return str.replace(/(.{1,50})(?:\n|$| )/g, "$1\n");;
  }

  function loading(loading) {
    $(".preloader").removeClass("show");
    if(loading){
      $(".preloader").addClass("show");
    }
  }

  function Planet(name, img, type) {

    planetIndex++;
    planets[planetIndex] = this;

    this.image = img;
    this.name = name;
    this.type = type;
    this.angle = 0;
    this.radius = (planetSettings.radius / 2) - planetSettings.orbitPadding * planetIndex;
    this.x = planetSettings.centerX + this.radius * Math.cos(this.angle);
    this.y = planetSettings.centerY - this.radius * Math.sin(this.angle);
    this.id = planetIndex;
  }
  Planet.prototype.draw = function() {
    var drawOrbit = true;
    var drawPlanet = true;
    var sun = false;
    switch (this.type) {
      case "planet":
        drawOrbit = true;
        drawPlanet = true;
        legende++;
        break;
      case "sun":
        drawOrbit = false;
        drawPlanet = true;
        sun = true;
        break;
      case "belt":
        drawOrbit = false;
        drawPlanet = false;
        break;
      default:

    }

    var body;
    var sunPos = {
      x: 0,
      y: 0
    };
    switch (this.name.toLowerCase()) {
      case "neptune":
        body = {
          x: T6.xNeptune,
          y: T6.yNeptune
        }
        break;
      case "uranus":
        body = {
          x: T6.xUranus,
          y: T6.yUranus
        }

        break;
      case "saturn":
        body = {
          x: T6.xSaturn,
          y: T6.ySaturn
        }
        break;
      case "mars":
        body = {
          x: T6.xMars,
          y: T6.yMars
        }
        break;
      case "venus":
        body = {
          x: T6.xVenus,
          y: T6.yVenus
        }
        break;

      case "jupiter":
        body = {
          x: T6.xJupiter,
          y: T6.yJupiter
        }
        break;

      case "mercury":
        body = {
          x: T6.xMercury,
          y: T6.yMercury
        }
        break;

      case "earth":
        body = {
          x: T6.xEarth,
          y: T6.yEarth
        }
        break;
      default:

    }

    if (body != null) {
      //this.angle = planetAngle(body,sunPos);
      this.x = planetSettings.centerX + (body.x * this.radius);
      this.y = planetSettings.centerY + (body.y * this.radius);
    }

    /*this.x = planetSettings.centerX + this.radius * Math.cos(this.angle);
    this.y = planetSettings.centerY - this.radius * Math.sin(this.angle);*/




    if (drawOrbit) {
      context.beginPath();
      context.arc(planetSettings.centerX, planetSettings.centerY, this.radius, 0, 2 * Math.PI, false);
      context.lineWidth = 4;
      context.setLineDash([5, 15]);
      if (darkui) {
        context.strokeStyle = 'rgba(0, 0, 0, .2)';
      } else {
        context.strokeStyle = 'rgba(255, 255, 255, .7)';
      }
      context.stroke();
    }
    var astroidRad = this.radius;
    if (!drawOrbit && !drawPlanet) {

      var astroid = new Image();
      astroid.onload = function() {

        var step = 2 * Math.PI / planetSettings.astroids;
        var h = planetSettings.centerX;
        var k = planetSettings.centerY;
        var r = astroidRad;

        for (var theta = 0.01; theta < 2 * Math.PI; theta += step) {

          //n = theta/step;

          r = astroidRad;

          var x = h + r * Math.cos(theta);
          var y = k - r * Math.sin(theta);

          context.save();
          context.translate(x, y);
          context.globalAlpha = .5;
          context.rotate((Math.random() * 360) * Math.PI / 180);
          context.drawImage(astroid, -astroid.width / 2, -astroid.height / 2);
          context.restore();
        }
      }
      var folder = darkui ? "black" : "white";
      astroid.src = mainurl+"images/planetsv2/" + folder + "/astroid.png";


    }

    if (drawPlanet) {

      var x = this.x;
      var y = this.y;

      if (sun) {
        x = planetSettings.centerX;
        y = planetSettings.centerY;
      }


      var img = new Image();
      var planetName = this.name;
      img.onload = function() {
        context.beginPath();
        context.fillStyle = mainColors[mainColor];
        context.arc(x, y, img.width / 2, 0, 2 * Math.PI, false);
        context.fill();

        context.drawImage(img, x - img.width / 2, y - img.height / 2);

        if (!sun) {

          var max = planetSettings.centerX + ((planetSettings.radius / 2) - planetSettings.padding);
          var min = planetSettings.centerX - ((planetSettings.radius / 2) - planetSettings.padding);
          var distance = max - min;
          var legendeX = min + (distance / (legende - 1)) * (legendeStep);
          legendeStep++;

          var legendeY = (canvas.height - canvas.height / 3.7);
          if (darkui) {
            drawString(context, planetName, legendeX, legendeY - 130, '#000000', 0, "Roboto Slab", 30, 20);
          } else {
            drawString(context, planetName, legendeX, legendeY - 130, '#ffffff', 0, "Roboto Slab", 30, 20);
          }
          context.drawImage(img, legendeX - img.width / 2, legendeY - img.height / 2);
        }

      }
      var folder = "white";
      if (darkui) {
        folder = "black";
      } else if (coloredui) {
        folder = "color";
      }

      img.src = mainurl+"images/planetsv2/" + folder + "/" + this.name.toLowerCase() + ".png";

    }

  }
  init();

  function wrapText(context, text, x, y, maxWidth, lineHeight) {
        var words = text.split(' ');
        var line = '';

        for(var n = 0; n < words.length; n++) {
          var testLine = line + words[n] + ' ';
          var metrics = context.measureText(testLine);
          var testWidth = metrics.width;
          if (testWidth > maxWidth && n > 0) {
            context.fillText(line, x, y);
            line = words[n] + ' ';
            y += lineHeight;
          }
          else {
            line = testLine;
          }
        }
        context.fillText(line, x, y);
      }

  function drawString(context, text, posX, posY, textColor, rotation, font, fontSize, lineHeight) {
    var lines = text.split("\n");
    if (!rotation) rotation = 0;
    if (!font) font = "'serif'";
    if (!fontSize) fontSize = 16;
    if (!textColor) textColor = '#000000';

    context.save();
    context.font = fontSize + "px " + font;
    context.fillStyle = textColor;
    context.rotate(rotation * Math.PI / 180);
    context.translate(posX, posY);
    for (i = 0; i < lines.length; i++) {
      context.fillText(lines[i], 0, i * 80);
    }

    context.restore();
  }

  function planetAngle(p1, p2) {
    return Math.atan2(p2.y - p1.y, p2.x - p1.x) * 180 / Math.PI;
  }

  function chunk(str, n) {
    var ret = [];
    var i;
    var len;

    for (i = 0, len = str.length; i < len; i += n) {
      ret.push(str.substr(i, n))
    }

    return ret
  };

  function formatDate(date) {
    var monthNames = [
      "January", "February", "March",
      "April", "May", "June", "July",
      "August", "September", "October",
      "November", "December"
    ];

    var day = date.getDate()+1;
    var monthIndex = date.getMonth();
    var year = date.getFullYear();

    return monthNames[monthIndex] + ' ' + day + ', ' + year;
  }
};
