function generateAmountRem(id){
    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let res = req.response;
            let list = JSON.parse(res);
            document.querySelector('.text p').innerHTML=`Amount Remaining : ${list[0]["amount"]}`;
        }
    };
    req.open("GET","../util/get_details.php?id_dorayaki="+id,true);
    req.send();
}


function deletePrompt(id){
       if (confirm("Delete this Item?")) {
        window.location.href = "../util/delete_variant.php?id_dorayaki=" +id;
    }
}

function buttonListeners(initPrice){
    document.getElementById('krg').addEventListener('click', function() {
        document.getElementById('qty').stepDown();
        })
    document.getElementById('tmb').addEventListener('click', function() {
        document.getElementById('qty').stepUp();
        
    })
    document.getElementById('qty').addEventListener("change", function(){
        // var initPrice = 4000
        var input = parseInt(document.getElementById('qty').value);
        var total = (input*initPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.getElementById('puraisu').innerHTML = "Rp"+total;
    });

    document.getElementById('krg').addEventListener('click', function(){
        // var initPrice = 4000;
        var input = parseInt(document.getElementById('qty').value);
        var total = (input*initPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.getElementById('puraisu').innerHTML = "Rp"+total;
    });
    document.getElementById('tmb').addEventListener('click', function(){
        // var initPrice = 4000;
        var input = parseInt(document.getElementById('qty').value);
        var total = (input*initPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.getElementById('puraisu').innerHTML = "Rp"+total;
    });
}