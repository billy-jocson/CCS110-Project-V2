<<<<<<< HEAD
getComponeyMoney();

document.getElementById("ADemployee").addEventListener("click", function (e) {
  if (e.target.classList.contains("aproveBtn")) {
    const id = e.target.getAttribute("data-id");
    approveRequest(id);
  }

  if (e.target.classList.contains("declineBtn")) {
    const id = e.target.getAttribute("data-id");
    declineRequest(id);
  }
});

function approveRequest(id) {
  const bodyData = new FormData();
  bodyData.append("id", id);
  bodyData.append("choice", 1);

  fetch("../controllers/approveNdecline.php", {
    method: "POST",
    body: bodyData,
  });
  alert("Approved");
  location.reload();
}

function declineRequest(id) {
  const bodyData = new FormData();
  bodyData.append("id", id);
  bodyData.append("choice", 2);

  fetch("../controllers/approveNdecline.php", {
    method: "POST",
    body: bodyData,
  });
  alert("Delined");
  location.reload();
}

function getComponeyMoney() {
  fetch("../controllers/getCompanyMoney.php")
    .then((response) => response.json())
    .then((data) => console.log(data));
}
=======
getComponeyMoney();

document.getElementById("ADemployee").addEventListener("click", function (e) {
  if (e.target.classList.contains("aproveBtn")) {
    const id = e.target.getAttribute("data-id");
    approveRequest(id);
  }

  if (e.target.classList.contains("declineBtn")) {
    const id = e.target.getAttribute("data-id");
    declineRequest(id);
  }
});

function approveRequest(id) {
  const bodyData = new FormData();
  bodyData.append("id", id);
  bodyData.append("choice", 1);

  fetch("../controllers/approveNdecline.php", {
    method: "POST",
    body: bodyData,
  });
  alert("Approved");
  location.reload();
}

function declineRequest(id) {
  const bodyData = new FormData();
  bodyData.append("id", id);
  bodyData.append("choice", 2);

  fetch("../controllers/approveNdecline.php", {
    method: "POST",
    body: bodyData,
  });
  alert("Delined");
  location.reload();
}

function getComponeyMoney() {
  fetch("../controllers/getCompanyMoney.php")
    .then((response) => response.json())
    .then((data) => console.log(data));
}
>>>>>>> c282d3b091bf6f3005d7ecc2311a5d95b4063715
