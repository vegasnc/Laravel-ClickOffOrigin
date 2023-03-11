feather.replace();

const controls = document.querySelector('.controls');
const video = document.querySelector('video');
const canvas = document.querySelector('canvas');
const screenshotImage = document.querySelector('img');
let streamStarted = false;

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
  // const isiPhone = true;

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

  var imgTagArr = $("#gallery .image-template");
  var imgTagCnt = imgTagArr.length;
  for(var x = 0; x < imgTagCnt; x ++) {
    var imgTag = imgTagArr[x];
    var width = imgTag.width;
    var height = imgTag.height;
    var parent_width = imgTag.parentElement.offsetWidth;
    imgTag.parentElement.style.height = parent_width + "px";
    if( width >= height ) {
      imgTag.classList.add("image-response-tablet");
    } else {
      imgTag.classList.add("image-response-mobile");
    }
  }

  $("form").on("submit", (e) => {
    $(".submit-div").html($("#loading-div").html());
  })

});

const handleImageSelect = async (event) => {
  $("#iosphotosection").show();
  var fileArr = event.target.files;
  var x = parseInt($("#photo_num").val());
  $("#photo_num").val(x + fileArr.length);
  for(let file of fileArr) {
    const fileReader = new FileReader();
    fileReader.onload = async () => {
        var path = fileReader.result;

        await getMeta(path, (err, img) => {
          $("#temp_gallery .photoData").attr("value", path);
          $("#temp_gallery .photoData").attr("name", "photo" + x);
          x ++;
          var imageWidth = $("#image_template").width();
          rateImage = img.naturalHeight / img.naturalWidth;
          var imageHeight;
          if ( rateImage <= 1 ) {
            imageHeight = imageWidth / img.naturalWidth * img.naturalHeight;
            $("#temp_gallery .image-template").removeClass("image-response-tablet");
            $("#temp_gallery .image-template").removeClass("image-response-mobile");
            $("#temp_gallery .image-template").addClass("image-response-tablet");
            
          } else {
            $("#temp_gallery .image-template").removeClass("image-response-tablet");
            $("#temp_gallery .image-template").removeClass("image-response-mobile");
            $("#temp_gallery .image-template").addClass("image-response-mobile");
          }
          $("#temp_gallery .image-item").height((imageWidth + 11) + "px")
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

const doScreenshot = async () => {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);

  var path = canvas.toDataURL('image/webp');

  await getMeta(path, (err, img) => {
      var photo_num = parseInt($("#photo_num").val());
      $("#photo_num").val(photo_num + 1);
      $("#temp_gallery .photoData").attr("value", path);
      $("#temp_gallery .photoData").attr("name", "photo" + photo_num);

      var imageWidth = $("#image_template").width();
      rateImage = img.naturalHeight / img.naturalWidth;
      var imageHeight;
      if ( rateImage <= 1 ) {
        imageHeight = imageWidth / img.naturalWidth * img.naturalHeight;
        $("#temp_gallery .image-template").removeClass("image-response-tablet");
        $("#temp_gallery .image-template").removeClass("image-response-mobile");
        $("#temp_gallery .image-template").addClass("image-response-tablet");
        
      } else {
        $("#temp_gallery .image-template").removeClass("image-response-tablet");
        $("#temp_gallery .image-template").removeClass("image-response-mobile");
        $("#temp_gallery .image-template").addClass("image-response-mobile");
      }
      $("#temp_gallery .image-item").height((imageWidth + 11) + "px")
      $("#temp_gallery .image-template").attr("src", path);
      var temp_gallery = $("#temp_gallery").html();
      $("#gallery").append(temp_gallery);

  });

  
};

const resizeCaptureImg = () => {
  var divWidth = $(".image-item").width();
  if(rateImage != -1) {
    $(".image-item").height(divWidth + "px");
  }
};

const getMeta = (url, cb) => {
  const img = new Image();
  img.onload = async () => await cb(null, img);
  img.onerror = async (err) => await cb(err);
  img.src = url;
};

$("#btn_screenshot").on("click", doScreenshot);

$(window).on('resize', function () {
  // Do something.
  resizeCaptureImg();
});
