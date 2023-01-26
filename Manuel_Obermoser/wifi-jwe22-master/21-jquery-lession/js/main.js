

let mySecretVariable    = 123;
let mySecondVar         = 444;
let myContent           = "Hey";



function myFunction () {
    // hier schreibt man den Funktions-Code
    let meineVariable = 123;

    if(test == 1) {
        // wenn test 1 ist, dann führe diesen Code aus
    } else {
        // anderfalls diesen Code
    }

    let var1 = document.getElementById('test');
    let var2 = document.getElementById('test').innerHTML;

    if(eventKey == 1 && var1 == 1 && var2 == 1) {

    }



    for ( let i = 0; i < 10; i++ ) {

    }

}


// plain javascript
let headline = document.getElementById('headline');
headline.style.textColor = "red";


// jquery variante
let headline1 = $('#headline');
headline1.css('color', 'red');



console.log(
    mySecretVariable
);










const username = 'hugo';
const password = 'asdf123'

if( username == 'marie' && password == 'sandman' ) {
    // wenn das Passwort stimmt führe den Code aus
    $('#headline').css('color', 'green');
} else {
    // anderfalls dieser Code
    $('#headline').css('color', 'red');
}







// not defined vs. undefined

// not defined
// console.log(xVariable);

// undefined
let yVariable;
console.log(typeof mySecretVariable);





let myStringVar = 'Hi';



console.log(mySecondVar + 'jksdhfksj');

console.log(
    `"${myStringVar}, I'm Jessica."`
);


let myArray = ['Milch', 'Brot', 'Butter'];


myArray.push('Banane');
myArray.pop();

delete myArray[2];



let myObject = {
    meinName: 'Zeichenkette',
    meinAlter: 12,
    weiblich: true,
    maennlich: null,
    speak: function() {
        return 'I have spoken...';
    },
};

// Object Zugriff
console.log(myObject.meinName);
console.log(myObject['meinName']);
