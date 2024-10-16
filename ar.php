<?php
session_start();
if (!isset($_POST['targetId'])) {
    echo "不正なデータが送信されました。";
    header('Location:https://app.saitama-cmcc.ac.jp/saitama-ar/~kadowaki/');
    exit;
}
if (!isset($_POST['lat'])) {
    echo "不正なデータが送信されました。";
    header('Location:https://app.saitama-cmcc.ac.jp/saitama-ar/~kadowaki/');
    exit;
}
if (!isset($_POST['long'])) {
    echo "不正なデータが送信されました。";
    header('Location:https://app.saitama-cmcc.ac.jp/saitama-ar/~kadowaki/');
    exit;
}
if (!isset($_POST['targetName'])) {
    echo "不正なデータが送信されました。";
    header('Location:https://app.saitama-cmcc.ac.jp/saitama-ar/~kadowaki/');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <script src="https://aframe.io/releases/1.6.0/aframe.min.js"></script>
    <script src="https://unpkg.com/aframe-look-at-component@0.8.0/dist/aframe-look-at-component.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script>
    <link rel="shortcut icon" href="favicon.ico" />
    <title>巡って埼玉</title>
    <style>
        #destinationSelection {
          position: fixed;
          z-index: 10000;
          background-color: #fff;
          padding: 10px;
          font-size: 25px;
          letter-spacing: 10px 10px;
          width: 100%;
          height: 8%;
          top: 0;
          left: 0;
          display: block;
        }
        #targetDistance {
          position: fixed;
          z-index: 10000;
          background-color: #fff;
          width: 100%;
          height: 8%;
          font-size: 20px;
          padding: 10px;
          bottom: 0;
          text-align: center;
          left: 0;
        }
        #arrived {
          scale: 1 1 1;
          position: fixed;
          z-index: 10000;
          background-color: transparent;
          padding: 20px;
          top: 10%;
          left: 25%;
          display: block;
        }
        #clear {
          scale: 1 1 1;
          position: fixed;
          z-index: 10000;
          background-color: transparent;
          padding: 20px;
          top: 30%;
          left: 25%;
          display: block;
        }
    </style>
</head>
<body style="margin: 0; overflow: hidden;">
    <button id="destinationSelection" onclick="location.href='swiper.html'">目的地変更</button>
    <div id="targetDistance"></div>
    <div id="arrived"></div>
    <div id="clear"></div>
    <a-scene
      vr-mode-ui="enabled: false"
      embedded
      arjs="sourceType: webcam; debugUIEnabled: false;" 
      denyButtonText:いいえ;allowButtonText:はい;cancelButtonText:キャンセル;deviceMotionMessage:このWebアプリはモーションセンサーを利用しています。モーションセンサーにアクセスしてよろしいですか？;
      mobileDesktopMessage:モバイル用Webサイトに切り替えてこの画面をリロードしてください。
      >
      <a-image
        id="ar-button"
        src = "./image/arrive.png"
        look-at="[gps-camera]"
        width="2" height="1"
        position=""
        scale=""
        gps-entity-place="latitude:<?php echo $_POST['lat']?>;longitude:<?php echo $_POST['long']?>;"
      >
      </a-image>
      <a-entity cursor="rayOrigin: mouse; fuse: false" raycaster="objects: .raycastable"></a-entity>
      <a-camera gps-camera rotation-reader>
        <a-entity id="north-arrow" position="0 -2.5 -10.5" rotation = "0 0 0">
          <a-cone color="red" radius-bottom="0.5" height="2" position="0 0 0" rotation="0 90 0"></a-cone>
          <a-text value="北" scale="4 4 1" position="-0 0 0" rotation="0 0 0"></a-text>
        </a-entity>
      </a-camera>
    </a-scene>
    <script>
        let latitude = 0;
        let longitude = 0;
        let flag = true;
        const targetLat = <?php echo $_POST['lat']?>;
        const targetLong = <?php echo $_POST['long']?>;
        const targetId = <?= json_encode($_POST['targetId']) ?>;
        const button = document.getElementById('ar-button');

        window.addEventListener('DOMContentLoaded', () => {
            if (button) {
                button.setAttribute("class", "raycastable");
                button.addEventListener('click', () => {
                    userArrived();
                    window.setTimeout(function() {
                        window.location.href="./swiper.html";  
                        }, 2000);
                    });
            } 
            var position_options = {
            enableHighAccuracy: true,
            timeout: 3000,
            maximumAge: 0
            };
            navigator.geolocation.watchPosition(getPosition, null, position_options);
        });

        function getPosition(event) {
            latitude = event.coords.latitude;
            longitude = event.coords.longitude;
            const distance = haversineDistance(latitude, longitude, targetLat, targetLong);
            updateDistanceDisplay(Math.round(distance), latitude, longitude);
        }

        function updateDistanceDisplay(distance) {
            let distanceText = document.getElementById('targetDistance');
            distanceText.innerHTML = '<?php echo $_POST['targetName']?>まで' + '<br>' + 'あと' + distance + 'メートル';
            if (500 >= distance && flag) {
                button.setAttribute("scale", "10 10 10");
            } else {
                button.setAttribute("scale", "0 0 0");
            }
        }

        function haversineDistance(lat1, lon1, lat2, lon2) {
            const R = 6371000;
            const toRadians = (degrees) => degrees * (Math.PI / 180);
            const lat1Rad = toRadians(lat1);
            const lon1Rad = toRadians(lon1);
            const lat2Rad = toRadians(lat2);
            const lon2Rad = toRadians(lon2);
            const deltaLat = lat2Rad - lat1Rad;
            const deltaLon = lon2Rad - lon1Rad;
            const a = Math.sin(deltaLat / 2) ** 2 + Math.cos(lat1Rad) * Math.cos(lat2Rad) * Math.sin(deltaLon / 2) ** 2;
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        window.onload = () => {
            window.addEventListener('deviceorientation', function(event) {
                const heading = event.webkitCompassHeading || event.alpha;
                if (heading !== null) {
                    const azimuth = CalculateAngle(latitude, longitude, targetLat, targetLong);
                    const target_azimuth = azimuth - heading;
                    const arrow = document.getElementById("north-arrow");
                    arrow.setAttribute('rotation', { x: (target_azimuth - 7), y: 90, z: 0 });
                }
            });
        }

        function CalculateAngle(nLat1, nLon1, nLat2, nLon2) {
            const nLat1Rad = nLat1 * (Math.PI / 180);
            const nLon1Rad = nLon1 * (Math.PI / 180);
            const nLat2Rad = nLat2 * (Math.PI / 180);
            const nLon2Rad = nLon2 * (Math.PI / 180);
            const y = Math.sin(nLon2Rad - nLon1Rad) * Math.cos(nLat2Rad);
            const x = Math.cos(nLat1Rad) * Math.sin(nLat2Rad) - Math.sin(nLat1Rad) * Math.cos(nLat2Rad) * Math.cos(nLon2Rad - nLon1Rad);
            let azimuth = Math.atan2(y, x);
            azimuth = azimuth * (180 / Math.PI);
            azimuth = (azimuth + 360) % 360;
            return azimuth;
        }

        function userArrived() {
            const formData = new FormData();
            formData.append("targetId", targetId);        
            console.log(formData);
            fetch('./arrive.php', {
                method: 'POST',
                body: formData
            })
            .then((response) => {
                if (!response.ok) {
                    console.log("データが送信できてません");
                }
            })
            .catch((error) => {
                console.log(error);
            })
        }
    </script>
</body>
</html>