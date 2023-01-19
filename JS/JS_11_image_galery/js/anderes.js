let myVariable = 12345;
let my;

console.log(myVariable.toString().length);



let myArray = [
    "N1",
    "N2",
    "N3",
    "N4",
    "N5"
];

myArray.push("N7"); //fügt ein Element am ende hinzu
delete myArray[5]; //löscht das 3. Element, aber die Länge bleibt gleich!!!!! Nicht sinnvoll besser Pop und shift
myArray.pop(); //löscht das letzte Element, und die Länge (.lenght) wird um 1 reduziert
myArray.shift(); //löscht das erste Element, und die Länge (.lenght) wird um 1 reduziert.

console.log("Länge " + myArray.length)
myArray.forEach(myFunction);


let myText = "123*456&";


for (let i = 0; i< myText.length;  i++){
    console.log(myText.charAt(i));
}


function testen(){

}





function myFunction(value, index){
    console.log(myArray[index]);    
}


