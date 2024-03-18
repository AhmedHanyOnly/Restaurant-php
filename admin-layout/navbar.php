<?php

$countOrdersNew = $connect->countOrdersNew('orders')['Counter'];
?>
<nav class="main-navbar">
  <div class="container-fluid d-flex align-items-lg-center align-items-stretch flex-column flex-xl-row gap-3 justify-content-between">
    <div class="logo">
      <div class="tog-active d-block d-lg-none" data-tog="true" data-active=".app">
        <i class="fas fa-bars"></i>
      </div>
      <div class="text d-none d-lg-block">مطعم الزعيم</div>
    </div>
    <div class="d-flex align-items-center gap-2rem">
      <div class="list-item d-none d-lg-flex">
        <a href="orders.php" class="main-btn">
          <span class="main-badge"><?php echo $countOrdersNew ?></span>
          الطلبات الحديثة
          <img src="./admin-assets/img/icons/bell-white.svg" alt="" class="icon" />
        </a>
      </div>
      <div class="dropdown info-user ms-auto">
        <button class="dropdown-toggle d-flex align-items-center gap-2 content" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="text">
            <div class="name">
              <i class="fas fa-angle-down"></i>
              المدير
            </div>
            <div class="dic">الادارة</div>
          </div>
          <div class="img">
            <img src="./admin-assets/img/icons/user-black.svg" alt="" class="icon" />
          </div>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li>
            <form action="/server.php" method="post">
              <button type="submit" name="logout" class="dropdown-item"> تسجيل الخروج </button>
          </li>
          </form>
        </ul>
      </div>
    </div>
  </div>
</nav>