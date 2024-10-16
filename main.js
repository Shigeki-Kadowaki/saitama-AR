function getSpots() {//スワイパーに目的地を設定.
    fetch('./swiper.php')
    .then((response) => {
        //console.log(response);
        if (!response.ok) {
            document.getElementById('swiper').innerText = 'データが取得できませんでした';
            throw new Error("エラーが発生しました");                
        }
         //console.log( response.text);
        return response.json();
    })
    .then((json) => {
        let html = '';
        json.forEach(target => {
        html += `
                <div class="swiper-slide > <div class="target_box">
                <img src="./image/${target.targetid}.png" 
                onclick="setTargetSpot(${target.targetid},${target.latitude},${target.longitude},'${target.name}')">`;
        if (target.comp == 1) {// 行ったことがある場合。
            html += `<img class="complete" src="./image/mc.png" />`;
        }
        html += `<div>${target.name}</div>
                 </div></div>`;
        });
        document.getElementById('swiper').innerHTML = html;

        // Swiperの初期化
        const swiper = new Swiper('.sample-slider', {
            loop: true,
            slidesPerView: 3,
            centeredSlides: true,
            effect: "coverflow",
            coverflowEffect: {
            rotate: 0,
            depth: 200,
            stretch: 30,
            modifier: 1,
            scale: 1,
            slideShadows: false,
        }, 
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            320: {
                slidesPerView: 1, // 小さい画面では1枚表示
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2, // 中くらいの画面では2枚表示
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3, // 大きな画面では3枚表示
                spaceBetween: 30,
            }
        }
        })
    })
    .catch((error) => {
        console.log(error);
    })
}

// 目的地のID,緯度、経度、名前を取得.
function setTargetSpot(targetId, latitude, longitude,targetName) {
    document.getElementById('targetId').value = targetId; 
    document.getElementById('lat').value = latitude; 
    document.getElementById('long').value = longitude;
    document.getElementById('targetName').value = targetName;
    
    document.target.submit();
}

window.addEventListener("load",getSpots);