feather.replace();

const controls = document.querySelector('.controls');
const video = document.querySelector('video');
const canvas = document.querySelector('canvas');
const screenshotImage = document.querySelector('img');
const buttons = [...controls.querySelectorAll('button')];
let streamStarted = false;

const [play, pause, screenshot] = buttons;

var rateImage = -1;

const constraints = {
  video: {
    width: {
      min: 1280,
      ideal: 1920,
      max: 2560,
    },
    height: {
      min: 720,
      ideal: 1080,
      max: 1440
    }
  }
};

const getCameraSelection = async () => {
  const devices = await navigator.mediaDevices?.enumerateDevices();
  const videoDevices = devices.filter((device) => device.kind === "videoinput");
  if (videoDevices[0]) {
      //TODO find the other cameras on the phone
      // document.querySelector("body").innerHTML = JSON.stringify(devices)
      return videoDevices[0];
  } else {
      return null;
  }
};

const ios = () => {
  if (typeof window === `undefined` || typeof navigator === `undefined`) return false;

  return /iPhone|iPad|iPod/i.test(navigator.userAgent || navigator.vendor || (window.opera && opera.toString() === `[object Opera]`));
};

$(document).ready(function() {
  const isiPhone = ios();

  if( !isiPhone ) {
    getCameraSelection().then((r) => {
        sessionStorage.setItem(
            "camera",
            JSON.stringify({
                ...constraints,
                deviceId: { exact: r.deviceId },
            })
        );
    }).catch(
        (e) => {
          console.log(e)
        }
    );
  }

  $("#btn_capture").on('click', ()=> {
    if( isiPhone ) {
      $("#btn_ios_capture").trigger("click");
    } else {
      $("#photosection").show();
      if (streamStarted) {
        video.play();
        return;
      }
      if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
        if (sessionStorage.getItem("camera")) {
          startStream(JSON.parse(sessionStorage.getItem("camera")));
        }
      }
    }
  })
});

const handleImageSelect = async (event) => {
  $("#iosphotosection").show();
  var fileArr = event.target.files;
  $("#photo_num").val(fileArr.length);
  var x = 0;
  for(let file of fileArr) {
    const fileReader = new FileReader();
    fileReader.onload = async () => {
        var path = fileReader.result;

        await getMeta(path, (err, img) => {
          $("#temp_gallery .photoData").attr("value", path);
          $("#temp_gallery .photoData").attr("name", "photo" + x);
          x ++;
          
          var imageWidth = $("#image_template").width() - 4;
          rateImage = img.naturalHeight / img.naturalWidth;
          var imageHeight = imageWidth / img.naturalWidth * img.naturalHeight;
          $("#temp_gallery .image-item").height((imageHeight + 4) + "px")
          $("#temp_gallery .image-template").attr("src", path);
          var temp_gallery = $("#temp_gallery").html();
          $("#gallery").append(temp_gallery);
        });
    }
    fileReader.readAsDataURL(file);
  }

}

const startStream = async (constraints) => {
  const stream = await navigator.mediaDevices.getUserMedia(constraints);
  handleStream(stream);
};

const handleStream = (stream) => {
  video.srcObject = stream;
  streamStarted = true;
  $("#btn_screenshot").removeClass("d-none");
};

const doScreenshot = () => {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);

  var path = canvas.toDataURL('image/webp');
  var photo_num = parseInt($("#photo_num").val());
  $("#photo_num").val(photo_num + 1);
  $("#temp_gallery .photoData").attr("value", path);
  $("#temp_gallery .photoData").attr("name", "photo" + photo_num);

  getMeta(path, (err, img) => {
    var imageWidth = $("#image_template").width() - 4;
    rateImage = img.naturalHeight / img.naturalWidth;
    var imageHeight = imageWidth / img.naturalWidth * img.naturalHeight;
    $("#temp_gallery .image-item").height((imageHeight + 4) + "px")
    $("#temp_gallery .image-template").attr("src", path);
    var temp_gallery = $("#temp_gallery").html();
    $("#gallery").append(temp_gallery);
  });

  
};

const resizeCaptureImg = () => {
  var divWidth = $(".image-item").width() - 4;
  var divHeight = divWidth * rateImage + 4;
  if(rateImage != -1) {
    $(".image-item").height(divHeight + "px");
  }
};

const getMeta = (url, cb) => {
  const img = new Image();
  img.onload = () => cb(null, img);
  img.onerror = (err) => cb(err);
  img.src = url;
};

$("#btn_screenshot").on("click", doScreenshot);

$(window).on('resize', function () {
  // Do something.
  resizeCaptureImg();
});