function modalOpen(){

  target = document.getElementById("output");

  target.innerHTML = "アカウントID : " + document.getElementById("reg_account").value;
  target.appendChild(document.createElement("br"));
  target.innerHTML += "パスワード : " + document.getElementById("reg_password").value;
  target.appendChild(document.createElement("br"));
  target.innerHTML += "メールアドレス : " + document.getElementById("mail_address").value;
  target.appendChild(document.createElement("br"));
  target.innerHTML += "名前 : " + document.getElementById("reg_name").value;

 //  モーダルウインドウ オープン
  document.getElementById("modalArea").className = "modalBg modalBgOpen";
}

function modalClose(){
 //  モーダルウインドウ クローズ
  document.getElementById("modalArea").className = "modalBg modalBgClose";
}
