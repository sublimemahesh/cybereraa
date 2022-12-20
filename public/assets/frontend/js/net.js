var Animation = function (id) {
  var canvas = document.getElementById(id);

  if (!canvas) {
    console.error('Error! The element with the id \"' + id + '\" does not exist.');
    return;
  }

  var ctx = canvas.getContext('2d');

  var updates = 0;

  var points = [];

  var connections = [];

  var mouse = {
    x: 0,
    y: 0 };


  canvas.style.width = '100%';
  canvas.style.height = '100%';
  canvas.width = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;

  canvas.addEventListener("resize", function () {
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
  });

  var Point = function (x, y, size, lifespan, direction, speed) {
    this.x = x;
    this.y = y;

    this.dx;
    this.dy;

    this.direction = direction;
    this.speed = speed;

    this.size = size;

    this.lifespan = lifespan;
    this.age = 0;

    this.alpha = 1;

    this.dead = false;

    this.birth = new Date();

    this.update = function () {
      var now = new Date();

      this.age = new Date(now - this.birth);

      if (this.age.getSeconds() >= this.lifespan && !this.dead) {
        this.dead = true;
      }

      if (this.x < 0 || this.x > canvas.width) {
        this.dead = true;
      }

      if (this.y < 0 || this.y > canvas.height) {
        this.dead = true;
      }
      if (this.lifespan - this.age.getSeconds() > this.lifespan - 1) {
        this.alpha = 1 * (this.age.getMilliseconds() / 1000 + this.age.getSeconds());
      } else if (this.lifespan - this.age.getSeconds() <= 2) {
        this.alpha = 1 / 2 * (this.lifespan - (this.age.getMilliseconds() / 1000 + this.age.getSeconds()));
      } else {
        this.alpha = 1;
      }

      this.dx = Math.cos(Math.PI / 180 * this.direction) * speed;
      this.dy = Math.sin(Math.PI / 180 * this.direction) * speed;

      this.x += this.dx;
      this.y += this.dy;
    };

    this.draw = function () {
      /*
      ctx.shadowBlur = 10;
      ctx.shadowOpacity = 0.5;
      ctx.shadowColor = "white";
      */
      ctx.fillStyle = "rgba(255,255,255," + this.alpha + ")";
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, 2 * Math.PI);
      ctx.fill();

      ctx.shadowBlur = 0;
    };

    this.distance = function (point) {
      var a = this.x - point.x;
      var b = this.y - point.y;

      var c = Math.sqrt(a * a + b * b);

      return c;
    };

    this.getAge = function () {
      return new Date(this.age);
    };
  };

  // Run loop
  animate();

  function animate() {
    updates++;
    // Update logic
    update();

    // Draw graphics
    draw();

    // Final recall for update loop
    window.getAnimationFrame(animate);
  };

  function update() {

    if (points.length < 75) {
      createRandomPoint();
    }

    for (var i = 0; i < points.length; i++) {
      points[i].update();
      if (points[i].dead) {
        points.splice(i, 1);
        console.log('dead');
      }
    }
  }

  function draw() {
    // Clear canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Draw background
    ctx.fillStyle = "#000000";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Draw connections
    for (var i = 0; i < points.length; i++) {
      for (var j = i; j < points.length; j++) {
        var point1 = points[i];
        var point2 = points[j];

        var thisDistance = point1.distance(point2);

        var maxDistance = 300;

        if (thisDistance < maxDistance) {
          var lineAlpha = 0.5 / maxDistance * (maxDistance - thisDistance) * point1.alpha * point2.alpha;
          /*
          ctx.shadowBlur = 10;
          ctx.shadowOpacity = 0.5;
          ctx.shadowColor = "white";
          */
          ctx.beginPath();
          ctx.moveTo(point1.x, point1.y);
          ctx.lineTo(point2.x, point2.y);
          ctx.lineWidth = 1;
          ctx.strokeStyle = "rgba(255,255,255," + lineAlpha + ")";
          ctx.stroke();

          ctx.shadowBlur = 0;
        }
      }
    }

    for (var i = 0; i < points.length; i++) {
      var point = points[i];

      var thisDistance = point.distance(mouse);

      if (thisDistance < 300) {
        var lineAlpha = 1 / 200 * (300 - thisDistance) * point.alpha;
        /*
        ctx.shadowBlur = 10;
        ctx.shadowOpacity = 0.5;
        ctx.shadowColor = "white";
        */
        ctx.beginPath();
        ctx.moveTo(point.x, point.y);
        ctx.lineTo(mouse.x, mouse.y);
        ctx.lineWidth = 1;
        ctx.strokeStyle = "rgba(255,255,255," + lineAlpha + ")";
        ctx.stroke();

        ctx.shadowBlur = 0;
      }
    }

    for (var i = 0; i < points.length; i++) {
      if (!points[i].dead) {
        points[i].draw();
      }
    }
    /*
    // Draw debugging
    ctx.fillStyle = "white";
    ctx.fillText('updates: ' + updates, 20, 20);
    */

  }

  function createRandomPoint() {
    var x = Math.floor(Math.random() * canvas.width);
    var y = Math.floor(Math.random() * canvas.height);

    var size = Math.floor(Math.random() * 2) + 1;

    var direction = Math.floor(Math.random() * 360);

    var speed = Math.ceil(Math.random() * 3) / 10;

    var lifespan = Math.floor(Math.random() * 10) + 5;

    points.push(new Point(x, y, size, lifespan, direction, speed));
  }

  function getMousePos(canvas, event) {
    var rect = canvas.getBoundingClientRect();
    return {
      x: event.clientX - rect.left,
      y: event.clientY - rect.top };

  }

  window.addEventListener('mousemove', function (e) {
    mouse = getMousePos(canvas, e);
  });
};

window.getAnimationFrame = function () {
  return window.requestAnimationFrame ||
  window.webkitRequestAnimationFrame ||
  window.mozRequestAnimationFrame ||
  window.oRequestAnimationFrame ||
  window.msRequestAnimationFrame ||
  function ( /* function */callback, /* DOMElement */element) {
    window.setTimeout(callback, 1000 / 60);
  };
}();

Math.roundTo = function (value, decimal) {
  return Math.round(value * decimal) / decimal;
};

var background = new Animation('hero-background');