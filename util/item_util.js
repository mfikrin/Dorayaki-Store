function generateDetails(id){
    // document.querySelector('.text').innerHTML+=`<p>Amount Sold :${Math.random()}</p>`;
    // var req = new XMLHttpRequest();
    // req.open("GET","../util/get_details.php?id_dorayaki="+id,true);
    // req.send();
    // req.onload = function(){
    //     let res = req.response;
    //     let list = JSON.parse(res);
    //     document.querySelector('.text').innerHTML+=`<p>Amount Sold : ${list[0]['id_dorayaki']}</p>`;
    // }
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