$(function(){
  var member_login = '';
  var member_name = '';

  member_login = window.sessionStorage.getItem(['member_login']);
  member_name = window.sessionStorage.getItem(['member_name']);
  console.log(member_name);

  $("#navbar").load("../login_navbar.html");

  if(member_login != null) {
    $("#member_name").html(member_name);
  }

  });