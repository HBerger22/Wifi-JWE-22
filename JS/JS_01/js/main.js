"use strict";
// speichern eines Wertes in eine Konstante
const text = "Tina";

// Ausgabe des konstanten wertes in das HTML Document im Tag mit der ID "text"
document.getElementById ("text").innerHTML = text;
// Ausgabe des konstanten Wertes in die Console
console.log (text);

// Es können Variablen und Konstanten mit dem gleichen Namen innerhalb verschiedener Geltungsbereiche verwendet werden, ist aber nicht sinnvoll
{
    const text = "Franz"
    console.log (text);
}

console.log (text);