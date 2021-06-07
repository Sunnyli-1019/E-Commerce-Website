var flag = 0;
function checkout(){
  // go to checkout page
  alert('Redirecting to payment......');

  }

function getXmlHttpRequest(){
    var xhr = null;
    if (window.XMLHttpRequest)
    {
    	xhr=new XMLHttpRequest();
    }
    else if(window.ActiveXObject)
    {
    	xhr=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
}

function addToCart(pid){
    var xhr = getXmlHttpRequest();
    xhr.onreadystatechange= function(){
      var DONE = 4; // readyState 4 means the request is done.
      var OK = 200; // status 200 is a successful return.
      if(xhr.readyState === DONE && xhr.status === OK){
            var data = JSON.parse(xhr.responseText);
        }
        else{
            console.log('Error:  '+ xhr.status); // An error occurred during the request.
        }
    };
    xhr.open("GET", "cart-process.php?pid="+pid,true);
    xhr.send();

    try{
        var storage = localStorage.getItem('cart_storage');
    }
    catch(Exception){
    }

    if(storage == undefined){
        storage = {};
    }
    else{
        storage = JSON.parse(storage);
    }

    if(storage[pid] == undefined){
        storage[pid] = 0;
    }
    storage[pid] += 1;


    localStorage.setItem('cart_storage', JSON.stringify(storage));
    document.getElementById("icart").innerHTML = "";
    restore_cart();
    calSubTotal(); 
}

function dropToCart(pid){
    var xhr = getXmlHttpRequest();
    xhr.onreadystatechange= function(){
      var DONE = 4; // readyState 4 means the request is done.
      var OK = 200; // status 200 is a successful return.
      if(xhr.readyState === DONE && xhr.status === OK){
            var data = JSON.parse(xhr.responseText);
        }
        else{
            console.log('Error:  '+ xhr.status); // An error occurred during the request.
        }
    };
    xhr.open("GET", "cart-process.php?pid="+pid,true);
    xhr.send();

    try{
        var storage = localStorage.getItem('cart_storage');
    }
    catch(Exception){
    }

    if(storage == undefined){
        alert("No this item in your cart");
    }
    else{
        storage = JSON.parse(storage);
    }

    if(storage[pid] == undefined){
        alert("No this item in your cart");
    }
    if (storage[pid] > 1){
        storage[pid] -= 1;
        localStorage.setItem('cart_storage', JSON.stringify(storage));
        document.getElementById("icart").innerHTML = "";
        calSubTotal(); 
        restore_cart();
    }
    else{
        delete storage[pid];
        localStorage.setItem('cart_storage', JSON.stringify(storage));
        document.getElementById("icart").innerHTML = "";
        calSubTotal(); 
        restore_cart();
    }
}

function calSubTotal(){
    // calculate subtotal
    var totalprice = 0;
    var storage = window.localStorage.getItem('cart_storage');
    storage = JSON.parse(storage);
    try{
        Object.keys(storage).forEach(key =>{
            var xhr = getXmlHttpRequest();
            xhr.onreadystatechange= function(){
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if(xhr.readyState === DONE && xhr.status === OK){
                var data = JSON.parse(xhr.responseText);
                var price = data[0].price;
                totalprice += price*storage[key];                   
                document.getElementById("subtotal").innerHTML = "Sub-total: $"+totalprice;
            }
            else{
                console.log('Error:  '+ xhr.status); // An error occurred during the request.
            }
        };
        xhr.open("GET", "cart-process.php?pid="+key,true);
        xhr.send();
        });
    }
    catch( Exception){
        console.log('Null in obj');
    }
    finally{
        document.getElementById("subtotal").innerHTML = "Sub-total: $"+totalprice;
    }
 }

 function restore_cart(){
    var storage = window.localStorage.getItem('cart_storage');
    storage = JSON.parse(storage);
    try{
        Object.keys(storage).forEach(key =>{
            var xhr = getXmlHttpRequest();
            xhr.onreadystatechange= function(){
                var DONE = 4; // readyState 4 means the request is done.
                var OK = 200; // status 200 is a successful return.
                if(xhr.readyState === DONE && xhr.status === OK){
                var data = JSON.parse(xhr.responseText);
                var text = document.createTextNode(data[0].name);
                var text2 = document.createTextNode(('$ ')+data[0].price);
    
                var tag = document.createElement("p");
                var tag2 = document.createElement("p");
                var tag3 = document.createElement("p");
                var tag4 = document.createElement("p");
                var input = document.createTextNode("No. of items: "+storage[key]);

                tag.appendChild(text);
                var element = document.getElementById("icart");
                element.appendChild(tag);
    
                tag2.appendChild(text2);
                element.appendChild(tag2);
    
                tag3.appendChild(input);
                element.appendChild(tag3);
    
                element.appendChild(tag4);
    
            }
            else{
                console.log('Error:  '+ xhr.status); // An error occurred during the request.
            }
        };
        xhr.open("GET", "cart-process.php?pid="+key,true);
        xhr.send();
    
        });
    }
    catch( Exception){
        console.log('Null in obj');
    }

    calSubTotal(); 
 }
