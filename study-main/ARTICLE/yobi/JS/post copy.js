

$('#btn_count_up').on('click', function () {
  for(i=0; i < $(".none").length; i++){
    $('.none').removeClass();
  }
});

function count(){
  var thisCount = $("#btn_count_up").html();
      thisCount = Number(thisCount);
      thisCount = thisCount + 1;
  $(".none").removeClass();
}