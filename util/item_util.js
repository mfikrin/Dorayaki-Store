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

// function sumPrice()
// {
//     var initPrice = document.getElementById('initpr').value;
//     var input = document.getElementById('qty').value;
//     var total = (input*initPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//     document.getElementById('harga').innerHTML = "Total Price :Rp"+total;
// }