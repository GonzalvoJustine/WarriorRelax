var countdownNumberEl = document.getElementById('countdown-number');
var launch = document.getElementById('launch-one');

const btnStartElement = document.getElementById('play');
const btnStopElement = document.getElementById('pause');

let timerTime = 0;

const number = 1;

var launch1 = document.getElementById('launch-' + 1);
var launch2 = document.getElementById('launch-' + 2);
var rest = document.getElementById('break');

var countdown = "0" + 5;

countdownNumberEl.textContent = countdown;

/******************************/
/*        Launch timer        */
/******************************/
var timer = setInterval(function() {
    if (countdown > 0) {
        countdown = --countdown <= -1 ? 5 : countdown;

    } else {
        countdown = 0;
    }
    countdownNumberEl.textContent = "0" + countdown;
}, 1000);

/******************************/
/*       Exercice timer       */
/******************************/

// getting Display minutes and seconds elements
const disMinutes = document.querySelector(".minute");
const disSeconds = document.querySelector(".secondes");

// getting input minutes and seconds elements
const inpMinutes = document.getElementById("inp-minute");
const inpSeconds = document.getElementById("inp-seconds");

// Additional Variables
let resume;

disMinutes.innerHTML = "00";
disSeconds.innerHTML = "00";

// making the timer
let interval;
let totalTime;

function textCorrection(element, value) {
    element.innerHTML = value < 10 ? "0" + value : value;
}

btnStartElement.addEventListener('click', startTimer = () => {
    if (!interval) {
        interval = setInterval(() => {
            const minutes = Math.floor(totalTime / 60);
            const seconds = totalTime % 60;

            textCorrection(disMinutes, minutes);
            textCorrection(disSeconds, seconds);

            if (totalTime > 0) {
                totalTime--;
            }
        }, 1000);
        resume = false;
    }
    btnStartElement.classList.add("d-none");
    btnStopElement.classList.remove("d-none");
});

btnStopElement.addEventListener('click', stopTimer = () => {
    clearInterval(interval);
    resume = true;
    interval = false;
    btnStopElement.classList.add("d-none");
    btnStartElement.classList.remove("d-none");
});

/******************************/
/*  Timer for each exercise   */
/******************************/

setTimeout(function() {
    clearInterval(timer);
    launch.classList.add("hidden-launch");
    launch1.classList.remove("d-none");
    launch1.classList.add("d-block");

    btnStopElement.classList.remove("d-none");
    btnStartElement.classList.add("d-none");

    totalTime = inpMinutes.value * 60 + inpSeconds.value * 1;

    if (inpMinutes.value != "" || inpSeconds.value != "") {

        interval = setInterval(() => {
            const minutes = Math.floor(totalTime / 60);
            const seconds = totalTime % 60;

            textCorrection(disMinutes, minutes);
            textCorrection(disSeconds, seconds);
            if (totalTime > 0) {
                totalTime--;
            } else if (totalTime === 0) {
                clearInterval(interval);
                launch1.classList.add("d-none");
                launch1.classList.remove("d-block");
                rest.classList.remove("d-none");
                rest.classList.add("d-block");
            }

        }, 1000);


    } else {
        disMinutes.innerHTML = "00";
        disSeconds.innerHTML = "00";
    }

    return totalTime;
}, 5000);

/******************************/
/*       Next exercice        */
/******************************/

