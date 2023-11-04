<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .sidebar {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #111;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
    }

    .openbtn {
      font-size: 30px;
      cursor: pointer;
      position: absolute;
      padding: 10px;
      margin-top: 10px;
    }

    .sidebar-content a {
      padding: 15px 25px;
      text-decoration: none;
      font-size: 25px;
      color: #818181;
      display: block;
      transition: 0.3s;
    }

    .sidebar-content a:hover {
      color: #f1f1f1;
    }

    .main-content {
      transition: margin-left 0.5s;
      padding: 16px;
      margin-left: 0;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <button class="openbtn" onclick="toggleNav()">☰ Open Sidebar</button>
    <div id="mySidebar" class="sidebar-content">
      <a href="#">Home</a>
      <a href="#">About</a>
      <a href="#">Services</a>
      <a href="#">Portfolio</a>
      <a href="#">Contact</a>
    </div>
  </div>
  <div class="main-content">
    <h2>Main Content</h2>
    <p>This is the main content area.</p>
  </div>
  <script src="script.js"></script>
</body>

</html>


<script>
  function toggleNav() {
    var sidebar = document.getElementById("mySidebar");
    var openbtn = document.querySelector(".openbtn");

    if (sidebar.style.width === "250px") {
      sidebar.style.width = "0";
      openbtn.innerHTML = "☰ Open Sidebar";
    } else {
      sidebar.style.width = "250px";
      openbtn.innerHTML = "× Close Sidebar";
    }
  }
</script>