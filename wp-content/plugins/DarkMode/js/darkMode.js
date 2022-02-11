
function setCookie(cName, cValue, expDays) {
        let date = new Date();
        date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
document.querySelector(".panel_trigger").style="display:none"
document.querySelector(".mobilemenu").style="background-color:#00475d"
var darkmodebutton
var title_value = document.querySelector('.becipe-fn-footer').innerHTML;
var pcmoon =  function(event) {document.querySelector('.becipe-fn-footer').innerHTML=title_value+(darkmodebutton);};
darkmodebutton='<div class="header_recipe darkmodeswitch" style="margin: 20px;"><label class="darkmodeswitch"style="margin: 20px;"><input id="check" class="darkmodeinput" type="checkbox"onclick="dark_click()" ><span class="slider"><img class="moon" src="http://oceanwp.test/wp-content/plugins/DarkMode/assets/moon.png" alt=""></span></label></div>';
pcmoon();
let cl_name=document.querySelector(".becipe_fn_header")
let cl_name1=document.querySelector(".header_nav_wraps")
let cl_name2=document.querySelector(".header_logo")
let cl_name3=document.querySelectorAll(".link")  
let cl_name4=document.querySelector(".logo_hamb")
cl_name4.style=("background-color:#f0ca6e")
var darkmode_on= function(){
        setCookie('mode',"darkon","1000");
        cl_name.style=("transition: 1s;");
        cl_name.classList.add("bgblack");
        cl_name2.classList.add("bordergray");
        cl_name2.style=("transition: 1s;");
        cl_name3[1].classList.add("textwht");
        cl_name3[2].classList.add("textwht");
        cl_name3[3].classList.add("textwht");
        cl_name3[4].classList.add("textwht");
        cl_name3[5].classList.add("textwht");
        cl_name3[0].classList.add("textwht");
        cl_name4.style=("background-color:#0f0f16")
        document.querySelector(".mobilemenu").style="background-color:#090909"
        document.querySelector(".becipe_fn_panel").style="background-color:#090909"
        document.querySelector(".hamburger").classList.remove("is-active")
        document.querySelectorAll("a")[5].style="background-color:#1e1e1e"
        document.querySelector("#becipe-recipe-search").style="background-color:black;color:blue"
        document.querySelector(".fn__title").style="color:white"
        document.querySelector(".becipe_fn_container_in").style="background-color:rgb(0 0 0 / 96%)"
        document.querySelector(".slider").style="background-color:#391f80"
        document.body.style="background-color:#020012"
        var item =document.querySelector(".becipe_fn_pagetitle");
        if(item !== null){
        item.classList.add("becipe_fn_pagetitle_darkmode")
        }
        var item1=document.querySelectorAll(".becipe_fn_container_in")[2]
        if(item1 !== null){
          item1.style="background-color=black"
          };

}
var darkmode_off= function(){
    setCookie('mode',"darkoff","1000");
    cl_name.classList.remove("bgblack");
    cl_name2.classList.remove("bordergray");
    cl_name3[1].classList.remove("textwht");
    cl_name3[2].classList.remove("textwht");
    cl_name3[3].classList.remove("textwht");
    cl_name3[4].classList.remove("textwht");
    cl_name3[5].classList.remove("textwht");
    cl_name3[0].classList.remove("textwht");
    cl_name4.style=("background-color:#f0ca6e")
    document.querySelector(".mobilemenu").style="background-color:#00475d"
    document.querySelector(".becipe_fn_panel").style="background-color:#ffffff"
    document.querySelector(".hamburger").classList.remove("is-active")
    document.querySelectorAll("a")[5].style="background-color:#f0ca6e"
    document.querySelector("#becipe-recipe-search").style="background-color:#fff"
    document.querySelector(".fn__title").style="color:#00000"
    document.querySelector(".becipe_fn_container_in").style="background-color:#fff"
    document.body.style="transition: 1s;background-color:#f6f3f6"
    document.querySelector(".slider").style="background-color:rgb(0, 195, 255)"
    var item =document.querySelector(".becipe_fn_pagetitle");
    if(item !== null){
        item.classList.remove("becipe_fn_pagetitle_darkmode")
    }


}

function dark_click (){
    var click_value=click_value = document.getElementById("check").checked
    if(click_value==true){
    darkmode_on()

    };

    if (click_value==false){
    darkmode_off()
    };
}function checkCookie() {
    let mode = getCookie('mode')
    if (mode =="darkon") {
        darkmode_on()

    }
      if(mode=="darkoff"){
        darkmode_off()
      }if(mode==undefined){
          darkmode_off
          
      }
    }checkCookie();


