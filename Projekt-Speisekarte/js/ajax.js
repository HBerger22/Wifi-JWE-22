"use strict";
let alleAllergene;
let speisen;
let getraenke;
let o_allergene={};

// Allergene Holen
$.get(
    'api/V1/Allergene',
    // '../projekt/api/V1/Allergene',
    function(data,status,rückgabe){
        alleAllergene=rückgabe.responseJSON;
        let agHTML="";
        $(alleAllergene).each((index, entry) => {
    
            agHTML = agHTML + '\n' + `
            
            <label class="allergene a${entry["klasse"]}"> ${entry["klasse"]}: ${entry["name"]}
                <input class="all" onclick="allergeneOnOff('al_${entry["klasse"]}')" type="checkbox" id="al_${entry["klasse"]}" name="Allergene" value="al-${entry["klasse"]}">
                <span class="checkmark"></span>
            </label>
                
            `;
        o_allergene["al_"+entry["klasse"]]=0;
        });

        $('#f_allergene').html(agHTML);
        // console.log(agHTML);        
    }
);

$.get(
    'api/V1/Speisen',
    function(data,status,rückgabe){
        speisen=rückgabe.responseJSON;
        let sHTML="";
        let kname="";
        let zaehler=0;
        $(speisen).each((index, entry) => {
            // kategorie (Vorspeise, Hauptspeise, ...)
            if(kname!=entry["kName"]){
                if(kname!=""){   
                    sHTML = sHTML +`</ul>`;
                }
                zaehler+=1;
                sHTML = sHTML + '\n' + `
                <button  id="s${zaehler}" onclick="einAusblenden('s${zaehler}')">${entry["kName"]}</button>
                <ul id="s${zaehler}u">
                `;
            }

            // einzelnen gerichte
            // vorbereitung Allergene
            let alText="";
            let alKlasse="";
            $(entry["allergene"]).each((indexA, entryA ) =>{
                if(entry["allergene"][indexA]["pBeinhaltetA"]==1){
                    if (alText==""){
                        alText="("+ entryA["klasse"];
                    } else {
                        alText+=","+ entryA["klasse"];                        
                    }
                        alKlasse+= ` c_al_${entryA["klasse"]} `;
                }
            });
            if(alText!=""){
                alText+=" *)";
            }

            // html ausgabe
            sHTML = sHTML + '\n' + `
            
            <li class="${alKlasse}"> 
                <div class="produkt"> ${entry["Name"]} </div> 
                <div class="details"> ${entry["Beschreibung"]} ${alText}</div>`
                // mehrere MEPs? (Menge/Einheit/Preise)
                $(entry["mengeEinheitPreis"]).each((indexMep, entryMep) =>{
                    sHTML = sHTML +`
                    <div class="preiseinheit">
                        <div class="einheit" > ${entryMep["menge"]} ${entryMep["eKuerzel"]} </div>
                        <div class="preis">€ ${entryMep["preis"]}</div> 
                    </div>`;
                });
                
                sHTML = sHTML +`</li>`;
            
            kname=entry["kName"];
        });
        sHTML = sHTML +`</ul>`;
        $('#speisen').html(sHTML);
        // console.log(sHTML);
    }
);

$.get(
    'api/V1/Drinks',
    function(data,status,rückgabe){
        getraenke=rückgabe.responseJSON;
        let sHTML="";
        let kname="";
        let zaehler=0;
        $(getraenke).each((index, entry) => {
            // kategorie (Biere, Warme Getraenke, ...)
            if(kname!=entry["kName"]){
                if(kname!=""){   
                    sHTML = sHTML +`</ul>`;
                }
                zaehler+=1;
                sHTML = sHTML + '\n' + `
                <button  id="d${zaehler}" onclick="einAusblenden('d${zaehler}')">${entry["kName"]}</button>
                <ul id="d${zaehler}u">
                `;
            }

            // einzelnen Getränke
            // vorbereitung Allergene
            let alText="";
            let alKlasse="";
            $(entry["allergene"]).each((indexA, entryA ) =>{
                if(entry["allergene"][indexA]["pBeinhaltetA"]==1){
                    if (alText==""){
                        alText="("+ entryA["klasse"];
                    } else {
                        alText+=","+ entryA["klasse"];                        
                    }
                        alKlasse+= ` c_al_${entryA["klasse"]} `;
                }
            });
            if(alText!=""){
                alText+=" *)";
            }
            
            sHTML = sHTML + '\n' + `
            <li class="${alKlasse}"> 
                <div class="produkt"> ${entry["Name"]} </div> 
                <div class="details"> ${entry["Beschreibung"]} ${alText}</div>`
                // mehrere MEPs? (Menge/Einheit/Preise)
                $(entry["mengeEinheitPreis"]).each((indexMep, entryMep) =>{
                    sHTML = sHTML +`
                    <div class="preiseinheit">
                        <div class="einheit" > ${entryMep["menge"]} ${entry["mengeEinheitPreis"][indexMep]["eKuerzel"]} </div>
                        <div class="preis">€ ${entry["mengeEinheitPreis"][indexMep]["preis"]}</div> 
                    </div>`;
                });
                
                sHTML = sHTML +`</li>`;
            
            kname=entry["kName"];
        });
        sHTML = sHTML +`</ul>`;
        $('#drinks').html(sHTML);
        // console.log(sHTML);
        
    }
);