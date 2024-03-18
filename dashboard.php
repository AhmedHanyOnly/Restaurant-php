<?php
include 'connect.php';
if (empty($_SESSION['userId'])) {
  header("location:login.php?error=يجب تسجيل الدخول اولا");
  exit();
}
$countUser = $connect->countTable('users')['Counter'];
$countProduct = $connect->countTable('products')['Counter'];
$countOrder = $connect->countTable('orders')['Counter'];
// print_r($countUser);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>الرئيسية</title>
  <!-- Normalize -->
  <link rel="stylesheet" href="admin-assets/css/normalize.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="admin-assets/css/bootstrap.rtl.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin-assets/css/all.min.css" />
  <!-- Main File Css  -->
  <link rel="stylesheet" href="admin-assets/css/main.css" />
  <!-- Font Google -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>

<body>
  <!-- Start layout -->
  <?php
  include 'admin-layout/navbar.php'
  ?>
  <div class="app-2">
    <div class="sidebar">
      <div class="tog-active d-none d-lg-block" data-tog="true" data-active=".app">
        <i class="fas fa-bars"></i>
      </div>
      <ul class="list">
        <li class="list-item active">
          <a href="dashboard.php">
            <div>
              <i class="fa-solid fa-grip"></i>
              الرئيسية
            </div>
          </a>
        </li>

        <li class="list-item">
          <a href="users.php">
            <div>
              <i class="fa-solid fa-grip"></i>
              العملاء
            </div>
          </a>
        </li>
        <li class="list-item">
          <a href="orders.php">
            <div>
              <i class="fa-solid fa-grip"></i>
              الطلبات
            </div>
          </a>
        </li>
        <li class="list-item">
          <a href="products.php">
            <div>
              <i class="fa-solid fa-grip"></i>
              المنتجات
            </div>
          </a>
        </li>
      </ul>
    </div>
    <div class="main-side">
      <div class="main-title">
        <div class="small">الرئيسية</div>
        <div class="large">لوحة التحكم</div>
      </div>
      <div class="row g-3 mb-2">
        <div class="col-12 col-md-6">
          <div class="card">
            <div class="card-header bg-white">المواعيد والاجتماعات</div>
            <div class="card-body">
              <div id="calendar"></div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <div class="box-statistic green">
                <div class="right-side">
                  <h6 class="name">العملاء</h6>
                  <h3 class="amount">
                    <span class="num-stat" data-goal=<?php echo $countUser ?>>0</span>
                  </h3>
                  <a href="" class="link-view">عرض كل العملاء</a>
                </div>
                <div class="left-side">
                  <p class="status-number up"></p>
                  <div class="icon-holder green">
                    <i class="fa-regular fa-circle-user"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="box-statistic blue">
                <div class="right-side">
                  <h6 class="name">الطلبات</h6>
                  <h3 class="amount">
                    <span class="num-stat" data-goal=<?php echo $countOrder ?>>0</span>
                  </h3>
                  <a href="" class="link-view">عرض جميع الطلبات</a>
                </div>
                <div class="left-side">
                  <p class="status-number down"></p>
                  <div class="icon-holder blue">
                    <i class="fa-solid fa-user-tie"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="box-statistic yellow">
                <div class="right-side">
                  <h6 class="name">المنتجات</h6>
                  <h3 class="amount num-stat" data-goal=<?php echo $countProduct ?>>0</h3>
                  <a href="" class="link-view">عرض كل المنتجات</a>
                </div>
                <div class="left-side">
                  <p class="status-number up"></p>
                  <div class="icon-holder yellow">
                    <i class="fa-solid fa-list"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End layout -->

  <script>
    if (document.querySelectorAll(".num-stat")) {
      let numStats = document.querySelectorAll(".num-stat");
      let started = false;
      document.addEventListener("DOMContentLoaded", function() {
        numStats.forEach((num) => startCount(num));
      });

      function startCount(el) {
        let goal = el.dataset.goal;
        let duration = 2000; // تحديد المدة الزمنية
        let start = null;

        function updateCount(timestamp) {
          if (!start) start = timestamp;
          let progress = timestamp - start;
          let increment = Math.floor((progress / duration) * goal);
          el.textContent = increment > goal ? goal : increment;
          if (progress < duration) {
            requestAnimationFrame(updateCount);
          }
        }
        requestAnimationFrame(updateCount);
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
  <script src="/js/ar.global.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const calendarEl = document.getElementById("calendar");
      const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "ar",
        initialView: "dayGridMonth",
        buttonText: {
          today: "اليوم",
          day: "world",
          week: "welcome",
          month: "hmmm",
        },
      });
      calendar.render();
    });
  </script>

  <!-- Js Files -->

  <script src="admin-assets/js/bootstrap.bundle.min.js"></script>
  <script src="admin-assets/js/all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="admin-asset/js/main.js"></script>
</body>

</html>