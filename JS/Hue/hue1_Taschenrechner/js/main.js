let ergebnis=0;
let zahl1=0;
let zahl2=0;

let letzteTasteZahl=false;
let operator = 0;
let aktiveZahl=1;


function berechnen(elem){
    console.log(elem);
    console.log(typeof(elem));
    console.log(letzteTasteZahl);
    
    // Eingabe = Zahl
    if(typeof(elem)=='number' && letzteTasteZahl==true){
        if (operator==0){
            zahl1=zahl1*10+elem;
            document.getElementById('ergebnis').innerHTML='Zahl 1: ' + zahl1;
        } else {
            zahl2=zahl2*10+elem;
            document.getElementById('ergebnis').innerHTML='Zahl 2: ' + zahl2;
            aktiveZahl=2;
        }
    } else if (typeof(elem)=='number' && letzteTasteZahl==false){
        if (operator==0){
            zahl1=elem;
            console.log('1. Fall');
            console.log(elem);
            console.log(zahl1);
            document.getElementById('ergebnis').innerHTML='Zahl 1: ' + zahl1;
        } else {
            zahl2=elem;
            document.getElementById('ergebnis').innerHTML='Zahl 2: ' + zahl2;
            aktiveZahl=2;
        }
        letzteTasteZahl=true;
    } else {
        console.log('seltsam');
    }

    // Eingabe = String
    if(typeof(elem)=='string' && elem != 'enter' && elem != 'vz'){
        operator=elem;
        letzteTasteZahl=false;
        console.log(operator);
        console.log('mistding1');
        aktiveZahl=2;
    } else if(typeof(elem)=='string' && (elem == 'enter' && elem != 'vz')) {
        switch (operator){
            case "+":
                ergebnis=zahl1+zahl2;
                break;
            case "-":
                ergebnis=zahl1-zahl2;
                break;
            case "*":
                ergebnis=zahl1*zahl2;
                break;
            case "/":
                ergebnis=zahl1/zahl2;
                break;
                        
        }
        // if(elem=='enter'){
            document.getElementById('ergebnis').innerHTML='Ergebnis: ' + ergebnis;
            letzteTasteZahl=false;
            ergebnis=0;
            operator=0;
            zahl1=0;
            zahl2=0;
            aktiveZahl=1;
        // } 
        console.log('mistding2');
    // Vorzeichen ändern.
    } else if(typeof(elem)=='string' && elem != 'enter' && elem == 'vz'){
        if(aktiveZahl==1){
            zahl1=zahl1 * -1;
            document.getElementById('ergebnis').innerHTML='Zahl 1: ' + zahl1;
        } else{
            zahl2=zahl2 * -1;
            document.getElementById('ergebnis').innerHTML='Zahl 2: ' + zahl2;
        }
        console.log('mistding3');
        console.log(zahl1);
    }

}