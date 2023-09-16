function visibilitapass() {
  pwd = document.getElementById("password");
  if (pwd.type == "password") {
    pwd.type = "text";
  } else {
    pwd.type = "password";
  }
}

function visibilitarepass() {
  repwd = document.getElementById("repassword");
  if (repwd.type == "password") {
    repwd.type = "text";
  } else {
    repwd.type = "password";
  }
}

function getObj(elementID){
  if (typeof elementID == "string") 
    return document.getElementById(elementID);
  else
    return elementID;
  }

function setVisibility(elementID,vis){
  var elemento = getObj(elementID);
  if (vis == true || vis=='block')
    elemento.style.display = "block";
  else
    elemento.style.display = "none";
  }
  
function mostraMenu(menuID) {
  setVisibility("scelte" + menuID, "block");
}

function nascondiMenu(menuID) {
  setVisibility("scelte" + menuID, "none");
}

function soloNumeri(event) {
  var tasto;
  tasto = event.key;
  if ((tasto == "Backspace") || (tasto == "Tab")) {
    return true;
  } else if ((("0123456789").indexOf(tasto) > -1)) {
    return true;
  }
  else {
    alert("Inserisci anno esempio '1990'");
    return false;
  }
}

let old = '';
let flag = true;

function playAudio(valore) {
    var x = document.getElementById(valore);
    if (flag == true) {
        old = x;
        x.play();
        flag = false;
    } else {
        if (x != old) {
            old.pause();
            old.currentTime = 0;
            old = x;
            x.play();
        }
    }
}

function pauseAudio(valore) {
    var x = document.getElementById(valore);
    if (x == old) {
        x.pause();
        flag = true;
    }
}

function mostra(contenuto,contenuto_Utente){
    var x = document.getElementById(contenuto);
    var xx = document.getElementById(contenuto_Utente);
    if(x.style.display == "block" && xx.style.display == "none"){
          x.style.display = "none";
          xx.style.display = "block";
    }else{
          x.style.display = "block";
          xx.style.display = "none";
    }
}

function SelezTT(oggUno,oggDue)
{
  var i = 0;
  var modulo = document.modulo.elements;
  for (i=0; i<modulo.length; i++)
  {
      if(modulo[i].type == "checkbox")
      {
          modulo[i].checked = !(modulo[i].checked);
      }
  }
    var x = document.getElementById(oggUno);
    var xx = document.getElementById(oggDue);
    if (oggUno  == 'sel' && oggDue == 'desc'){
      x.style.display = 'none';
      xx.style.display = 'block';
    }else{
      x.style.display = 'none';
      xx.style.display = 'block';
    }

}