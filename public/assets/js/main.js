const noir = document.querySelectorAll("#Noir");
const blanc = document.querySelectorAll("#Blanc")
const polyRight = document.querySelector(".polyRight");
const polyLeft = document.querySelector(".polyLeft");

function hoverQuestion1(color, polygone){
    color.forEach(answer =>  {
        answer.addEventListener("mouseover", () =>{
            polygone.style.transform = "scale(2)";
        })
        answer.addEventListener("mouseout", () =>{
            polygone.style.transform = "scale(1)";
        })
    })
}
hoverQuestion1(noir, polyRight);
hoverQuestion1(blanc, polyLeft)


const shortBunny = document.querySelectorAll("#shortBunny");
const shortBunnyEmpty = "../assets/images/media/courtBaloonBunny.png";
const shortBunnyFill = "../assets/images/media/courtBaloonBunnyFill.png";

const longBunny = document.querySelectorAll("#longBunny");
const longBunnyEmpty = "../assets/images/media/longBaloonBunny.png";
const longBunnyFill = "../assets/images/media/longBaloonBunnyFill.png";

function hoverQuestion3(image, image1, image2){
    image.forEach(item => {
        item.addEventListener("mouseover", () =>{
            item.src = image2;
        })
        item.addEventListener("mouseout", () =>{
            item.src = image1;
        })

    })
}

hoverQuestion3(shortBunny, shortBunnyEmpty, shortBunnyFill);
hoverQuestion3(longBunny, longBunnyEmpty, longBunnyFill);

const container = document.querySelector('.bgContact');

window.onmousemove = function (e) {
    let x = e.clientX / 8;
    let y = e.clientY / 8;

    container.style.backgroundPositionX = x + 'px';
    container.style.backgroundPositionY = y + 'px';

}