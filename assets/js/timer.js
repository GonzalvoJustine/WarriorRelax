let countdownNumberEl = document.getElementById('countdown-number');
let launch = document.getElementById('launch-one');
let end = document.getElementById('end');

const btnStartElement = document.getElementById('play');
const btnStopElement = document.getElementById('pause');

if(document.getElementById("total") != null){
    var total = document.getElementById("total").innerHTML;
}

const numberMax = total;

let number = 1;

let timerTime = 0;

let launchExercice;

let rest = document.getElementById('break');

let countdown = "0" + 5;

if(countdownNumberEl != null){
    countdownNumberEl.textContent = countdown;
}

/******************************/
/*        Launch timer        */
/******************************/

let timer = setInterval(function() {
    if (countdown > 0) {
        countdown = --countdown <= -1 ? 5 : countdown;

    } else {
        countdown = 0;
    }
    if(countdownNumberEl != null) {
        countdownNumberEl.textContent = "0" + countdown;
    }
}, 1000);

/******************************/
/*       Exercice timer       */
/******************************/

// getting Display minutes and seconds elements
let disMinutes = document.getElementById("minute-"  + number );
let disSeconds = document.getElementById("secondes-" + number);
const timerMinute = document.querySelector(".timer-minute");
const timerSeconds = document.querySelector(".timer-secondes");

// getting input minutes and seconds elements
let inpMinutes = document.getElementById("inp-minute-" + number);
let inpSeconds = document.getElementById("inp-seconds-" + number);
const inpTimerMinutes = document.getElementById("inp-timer-minute");
const inpTimerSeconds = document.getElementById("inp-timer-seconds");

// Additional Variables
let resume;

if(disMinutes != null){
    disMinutes.innerHTML = "00";
}
if(disSeconds != null){
    disSeconds.innerHTML = "00";
}
if(timerMinute != null){
    timerMinute.innerHTML = "00";
}
if(timerSeconds != null){
    timerSeconds.innerHTML = "00";
}

// making the timer
let interval;
let totalTime;

function textCorrection(element, value) {
    element.innerHTML = value < 10 ? "0" + value : value;

}
if(btnStartElement != null) {
    btnStartElement.addEventListener('click', startTimer = () => {
        if (!interval) {
            interval = setInterval(() => {
                const minutes = Math.floor(totalTime / 60);
                const seconds = totalTime % 60;

                textCorrection(disMinutes, minutes);
                textCorrection(disSeconds, seconds);
                textCorrection(timerMinute, minutes);
                textCorrection(timerSeconds, seconds);

                if (totalTime > 0) {
                    totalTime--;
                }
            }, 1000);
            resume = false;
        }
        btnStartElement.classList.add("d-none");
        btnStopElement.classList.remove("d-none");
    });
}

if(btnStopElement != null) {
    btnStopElement.addEventListener('click', stopTimer = () => {
        clearInterval(interval);
        resume = true;
        interval = false;
        btnStopElement.classList.add("d-none");
        btnStartElement.classList.remove("d-none");
    });
}

function launchExercise(number) {
    interval = setInterval(() => {
        let minutes = Math.floor(totalTime / 60);
        let seconds = totalTime % 60;

        textCorrection(disMinutes, minutes);
        textCorrection(disSeconds, seconds);

        if (totalTime > 0) {
            totalTime--;
        } else if (totalTime === 0) {
            clearInterval(interval);

            launchExercice.classList.add("d-none");
            launchExercice.classList.remove("d-block");

            totalTimeRest = inpTimerMinutes.value * 60 + inpTimerSeconds.value * 1;

            rest.classList.remove("d-none");
            rest.classList.add("d-block");

            if (inpTimerMinutes.value != "" || inpTimerSeconds.value != "") {
                intervalTimer = setInterval(() => {
                    const minutes = Math.floor(totalTimeRest / 60);
                    const seconds = totalTimeRest % 60;

                    textCorrection(timerMinute, minutes);
                    textCorrection(timerSeconds, seconds);

                    if (totalTimeRest > 0) {
                        totalTimeRest--;
                    } else if (totalTimeRest === 0) {
                        clearInterval(intervalTimer);

                        rest.classList.add("d-none");
                        rest.classList.remove("d-block");
                        number++;

                        if(number <= numberMax) {
                            launchExercice = document.getElementById('launch-' + number);
                            disMinutes = document.getElementById("minute-"  + number );
                            disSeconds = document.getElementById("secondes-" + number);
                            inpMinutes = document.getElementById("inp-minute-" + number);
                            inpSeconds = document.getElementById("inp-seconds-" + number);
                            disMinutes.innerHTML = "00";
                            disSeconds.innerHTML = "00";
                            launchExercice.classList.remove("d-none");
                            launchExercice.classList.add("d-block");

                            totalTime = inpMinutes.value * 60 + inpSeconds.value * 1;

                            launchExercise(number);
                        } else {
                            end.classList.remove("d-none");
                            end.classList.add("d-block");
                        }
                    }

                }, 1000);
            }
        }
    }, 1000);
}

/******************************/
/*  Timer for each exercise   */
/******************************/

setTimeout(function() {
    clearInterval(timer);

    if (launch != null) {
        launch.classList.add("hidden-launch");
    }
    if (btnStopElement != null) {
        btnStopElement.classList.remove("d-none");
    }
    if (btnStartElement != null) {
        btnStartElement.classList.add("d-none");
    }

    launchExercice = document.getElementById('launch-' + number);

    if (launchExercice != null) {
        launchExercice.classList.remove("d-none");
        launchExercice.classList.add("d-block");
    }

    if(inpMinutes != null || inpSeconds != null) {
        totalTime = inpMinutes.value * 60 + inpSeconds.value * 1;

        if (inpMinutes.value != "" || inpSeconds.value != "") {

            launchExercise(number);

        } else {
            disMinutes.innerHTML = "00";
            disSeconds.innerHTML = "00";
            timerMinute.innerHTML = "00";
            timerSeconds.innerHTML = "00";
        }
    }

    return totalTime;

}, 5000);
