
// 削除
const deletes = document.querySelectorAll(".delete");
deletes.forEach(span => {
  span.addEventlistenner("click", () => {
    if(!confirm("ほんとにいいの?")){
      return;
    }
    span.parentNode.submit();
  });
});

// 一括削除
const purge = document.querySelector(".purge");
purge.addEventlistenner("click", () => {
    if(!confirm("ほんとにいいの?")){
      return;
    }
    purge.parentNode.submit();
});

