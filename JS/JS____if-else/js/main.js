"use strict";

let i;
console.log(typeof i);
if(i==1){
    console.log('I ist 1');
}

if (typeof i == 'undefined'){
    console.log('i ist nicht definiert worden!!!');
}

let alter = 10
let geschlecht = 'm';

if (alter>= 18){
    console.log('Du bist volljährig');
} else {
    console.log('Du bist noch keine 18 Jahre alt!');
}

// === nicht nur das ergebnis muss stimmen sondern auch der Datentyp!!!
if(alter === "10"){
    console.log('es ist ein String');
} else {
    console.log('es ist keine Zahl, eventuell ein string')
}

// Kurzversion
console.log(alter == 10 ? 'stimmt' : 'stimmt nicht');
console.log(alter == 11 ? '11' : alter == 10 ? '10' : 'nicht elf');

// logisches verknüpfen mehrer Bedingungen "und"
if (alter == 10 && geschlecht =='m'){
    console.log('es ist ein junge mit 10 Jahren')
}
// oder
if (alter == 10 || geschlecht =='m'){
    console.log('es ist ein junge oder die person ist 10 Jahre alt')
}

