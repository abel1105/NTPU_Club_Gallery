function GetChecked(inputName)
{
  var test=0;
  $("input[name='"+ inputName +"']").each(function(){
    if($(this).prop("checked")){
      test = 1 ;
      return false;
    }else{
      return;
    }
  })
  return test;
}
function check_form_album_add() {
  var errorMsg = "";
  if ($('#at_name').val() === '') {
    errorMsg += "\n請先輸入欲新增的相簿名";
  }
  if (errorMsg == "") {
    return true;
  }
  else {
    alert(errorMsg);
    return false;
  }
}
function check_form_album_delete() {
  var errorMsg = "";
  var selectalbum = GetChecked('select_album_type[]');
  if (selectalbum == 0) {
    errorMsg += "\n請先打勾後再刪除";
  }
  if (errorMsg == "") {
    return true;
  }
  else {
    alert(errorMsg);
    return false;
  }
}
function check_form_add_club() {
  var errorMsg = "";
  if ($("#c_name").val() === "") {
    errorMsg += "\n請輸入欲新增的社團名稱";
  }
  if ($("#c_type").val() === "") {
    errorMsg += "\n請選擇欲新增的社團分類";
  }
  if (errorMsg == "") {
    return true;
  }
  else {
    alert(errorMsg);
    return false;
  }
}
function check_form_delete_club() {
  var errorMsg = "";
  if ($("#club_name").val() === "") {
    errorMsg += "\n請選擇欲刪除的社團";
  }
  if (errorMsg == "") {
    return true;
  }
  else {
    alert(errorMsg);
    return false;
  }
}
function check_form_photo_add() {
  var errorMsg = "";
  if ($("input[type='file']").val() === "") {
    errorMsg += "\n請先上傳檔案後再新增";
  }
  if (errorMsg == "") {
    return true;
  }
  else {
    alert(errorMsg);
    return false;
  }
}
function check_form_photo_delete() {
  var errorMsg = "";
  var selectphoto = GetChecked('select_photo[]');
  if (selectphoto == 0) {
    errorMsg += "\n請先打勾後再刪除";
  }
  if (errorMsg == "") {
    return true;
  }
  else {
    alert(errorMsg);
    return false;
  }
}
