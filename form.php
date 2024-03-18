<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>الرئيسية</title>
  <!-- Normalize -->
  <link rel="stylesheet" href="css/normalize.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/all.min.css" />
  <!-- Main Faile Css  -->
  <link rel="stylesheet" href="css/main.css" />
  <!-- Font Google -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500;600;700;800&display=swap" rel="stylesheet" />
</head>

<body>
  <!-- Start Top Nav Bar -->
  <nav class="top-nav not-print">
    <div class="container">
      <a href="#" class="tog-show" data-show=".top-nav .list-item"><i class="fa-solid fa-bars"></i></a>
      <ul class="list-item">
      </ul>
      <ul class="d-flex gap-3 align-items-center py-2">
        <li>
          <div class="dropdown-hover" data-show="dropdown-lang">
            <div class="icon-drop">
              <i class="fa-solid fa-user icon"></i>
            </div>
            <p class="text">محمد السيد</p>
            <div class="arrow-icon">
              <i class="fa-solid fa-angle-down"></i>
            </div>
            <ul class="listis-item" id="dropdown-lang">
              <li class="item-drop">
                <a href="#">
                  <form class="w-100" action="" method="" id="logout-form">
                    <button class="border-0 bg-transparent p-0">
                      <p class="text  d-flex">تسجيل الخروج</p>
                    </button>
                  </form>
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Top Nav Bar -->
  <!-- Start Bottom Nav Bar -->
  <nav class="bottom-nav not-print">
    <div class="container">
      <a href="#" class="tog-show" data-show=".bottom-nav .list-item"><i class="fa-solid fa-bars"></i></a>
      <ul class="list-item">
        <li>
          <a class="item" href="index.html">
            الرئيسية
            <i class="i-item fa-solid fa-house"></i>
          </a>
        </li>
    </div>
  </nav>
  <!-- End Bottom Nav Bar -->
  <!-- Start Section -->
  <?php
  $DBjson = file_get_contents('database.json');
  $users = json_decode($DBjson, true)
  ?>
  <section class="main-section home ">
    <div class="container">
      <?php
      if (isset($_GET['success'])) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
        echo "<strong>";
        echo $_GET['success'];
        echo "</strong>";
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        echo "</div>";
        
      }
      ?>
      <div class="small-heading my-3">بيانات الحسابات</div>
      <div class="box-content">
        <div class="table-responsive">
          <table class="table main-table mb-0">
            <thead>
              <tr>
                <th class="text-center">الصورة</th>
                <th class="text-center">الاسم</th>
                <th class="text-center">البريد الالكتروني</th>
                <th class="text-center">رقم الهاتف</th>
                <th class="text-center">كلمة المرور</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($users as $user) {
                echo "<tr>";
                echo "<td> <img width='100px' src= 'images/" . $user['image'] . "'> </td>";
                echo "<td>" . $user['name'] .  "</td>";
                echo "<td>" . $user['email'] .  "</td>";
                echo "<td>" . $user['phone'] .  "</td>";
                echo "<td>" . $user['password'] .  "</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!-- End Section -->
  <!-- Start Footer -->
  <div class="footer-bottom py-3 not-print">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <p>جميع الحقوق محفوظة © لـ 2022</p>

      </div>
    </div>
  </div>
  <!-- ENd Footer -->
  <!-- Js Files -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/all.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>