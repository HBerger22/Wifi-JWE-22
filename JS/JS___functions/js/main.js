"use strict";
console.log('Servus');

const anzeigejs = document.getElementById('anzeige');
let temp = 24; 
console.log(temp);
anzeigejs.innerText = temp + '°';
checkTempAndSetColor()


function temperaturHoch(){
    temp ++;
    console.log(temp);
    anzeigejs.innerText = temp +'°';
    checkTempAndSetColor();
}

function temperaturRunter(){
    temp --;
    console.log(temp);
    anzeigejs.innerText = temp +'°';
    checkTempAndSetColor();
    
}

function checkTempAndSetColor(){
    // in Variablen können auch Elemente geschrieben werden.
    let tempcolor =document.getElementsByTagName('div')[0];
    if (temp > 18 ){
        tempcolor.style.color = '#d80000';
    } else {
        tempcolor.style.color = 'lightblue';
    }
}

/*function checkTempAndSetColor(){
    let tempcolor;

    switch (temp) {
        case 18:
            tempcolor ='blue';
            break;
        case 20:
                tempcolor ='lightblue';
                break;
        case 22:
            tempcolor ='green';
            break;
        case 24:
            tempcolor ='red';
            break;
                                
        default:
            tempcolor ='black';
            break;
    }
    tempcolor =document.getElementsByTagName('div')[0].style.color=tempcolor;
}
*/