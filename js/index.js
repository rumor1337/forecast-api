function darkMode() {
    if (document.getElementById("textMode").textContent == "Dark") {
        lightMode();
    } else {
        var r = document.querySelector(':root');
        document.getElementById("textMode").textContent = "Dark";
        r.style.setProperty('--bg-color', 'rgb(31, 41, 55)');
        r.style.setProperty('--white', 'rgb(75, 85, 99)');
        r.style.setProperty('--black', 'rgb(255,255,255)');
        r.style.setProperty('--gray-500', rgb(255,255,255));
        r.style.setProperty('--gray-600', rgb(255,255,255));
        r.style.setProperty('--gray-800', rgb(255,255,255));
        r.style.setProperty('--gray-900', rgb(255,255,255));
    }
}

function lightMode() {
    var r = document.querySelector(':root');
    document.getElementById("textMode").textContent = "Light";
    r.style.setProperty('--bg-color', '#f3f4f6');
    r.style.setProperty('--white', 'rgb(255,255,255)');
    r.style.setProperty('--black', 'rgb(0, 0, 0)');
}

$(document).ready(function () {
    var metricImperial = document.getElementById('selector');
    metricImperial.onchange = (event) => {
        var currentValue = event.target.value;
        if(currentValue == "Celsius") {
            $('.metricC').text('°C');
            $('.kmh').text('km/h');
        }
        if(currentValue == "Fahrenheit") {
            $('.metricC').text('°F');
            $('.kmh').text('mph');
        }
    }
});
