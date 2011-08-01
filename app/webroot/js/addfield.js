var counter = 1;
var limit = 3;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " seats");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = 'Seat ' + (counter + 1) + ' <br><input name="data[Seat][' + (counter) +'][items]" type="text" class="text" maxlength="50" value="" id="Seat' + (counter) + 'Items">';
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}