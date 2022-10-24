//로그인 버튼
const btn = document.querySelector("#header .right .loginBtn");
const popup = document.querySelector(".login__popup");
const closeBtn = document.querySelector(".login__popup .btn-close");

btn.addEventListener("click", ()=>{
    popup.classList.add("open");
})

closeBtn.addEventListener("click", ()=>{
    popup.classList.remove("open");
})