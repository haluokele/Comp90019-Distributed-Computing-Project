
var aptid=0;
function check_empty() {
    if (document.getElementById('name').value == "" || document.getElementById('email').value == "" || document.getElementById('msg').value == "") {
        alert("Fill All Fields !");
    } else {
        document.getElementById('form').submit();
        alert("Form Submitted Successfully...");
    }
}
function schedule($what) {
    var myWindow;
    var url = "reschedule.php?id="+$what;
    myWindow = window.open(url, $what, "width=300,height=240,toolbar=no,scrollbars=no,resizable=no,left=40%, top=");
}
function set(id){
    aptid = id;
}

function getaptid(){
    return aptid;
}
function show1(){
    var form = document.getElementById("popupwindow1");
    form.style.display = "block";
}

function show2(){
    var form = document.getElementById("popupwindow2");
    form.style.display = "block";
}

function reload() {
    location.reload(true);
}
function test(){
    document.write(aptid);
}
function assign1(){
    document.getElementById('aptid1').value = getaptid();
}
function assign2(){
    document.getElementById('aptid2').value = getaptid();
}








