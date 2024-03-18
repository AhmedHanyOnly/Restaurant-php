<?php
include("./connect.php");
if (empty($_SESSION['userId'])) {
  header("location:login.php?error=يجب تسجيل الدخول اولا");
  exit();
}
$dataUser = $_SESSION['userId'];
$dataUser = $connect->getId('users', "$dataUser");


// print_r($dataUser['phone'])
?>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>بروفايل</title>
  <!-- Main Css Normalize File -->
  <link rel="stylesheet" href="front-assets/css/normalize.css" />
  <!-- Main Css Bootstrap RTL File -->
  <link rel="stylesheet" href="front-assets/css/bootstrap.rtl.min.css" />
  <!-- Main Css FontAwesome File -->
  <link rel="stylesheet" href="front-assets/css/all.min.css" />
  <!-- Main Css File -->
  <link rel="stylesheet" href="front-assets/css/main.css" />
  <!-- Main Css Fonts File -->
  <!-- <link rel="stylesheet" href="fonts/stylesheet.css" /> -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>

<body class=''>
  <nav class="navbar bottom-nav navbar-expand-lg">
    <div class="container">
      <span class="logo">
        <span>مطعم الزعيم</span>
      </span>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center mt-3 mt-lg-0 collapse navbar-collapse">
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="home.php">
                <i class="fa-solid fa-house me-2"></i>
                الرئيسية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="orders-menu.php">
                <i class="fa-solid fa-user me-2"></i>
                الطلبات</a>
            </li>

          </ul>
        </div>
        <div class="flex-grow-0 collapse navbar-collapse" id="navbarSupportedContent">
          <div class="d-flex">
            <div class="dropdown">
              <button class="btn-nav profile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                if (isset($dataUser['image'])) {
                  echo "<img src='./images/" . $dataUser['image'] . "' alt='' />";
                } else {
                  echo "<img src='./img/empty.jpg' alt='' />";
                }
                ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-nav">
                <li>
                  <a class="dropdown-item" href="profile.php">
                    <i class="fa-solid fa-gear me-2"></i>
                    البروفايل
                  </a>
                </li>
                <li>
                  <form action="./server.php" method='post'>
                    <button type="submit" name="logout" class="dropdown-item">
                      <i class="fa-solid fa-briefcase me-2"></i>
                      تسجيل الحروج
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <section class="py-5 " style=' min-height:94vh;'>
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-md-3">
          <div class="side-profile">
            <div class="avatar">'
              <?php
              if (isset($dataUser['image'])) {
                echo "<img src='./images/" . $dataUser['image'] . "' alt='' />";
              } else {
                echo "<img src='./img/empty.jpg' alt='' />";
              }
              ?>
            </div>
            <div class="title-name">
              <span class="name">
                <?php
                if (isset($dataUser['name'])) {
                  echo $dataUser['name'];
                }
                ?>
              </span>
            </div>
            <div class="taps-control">
              <ul>
                <li class="main-tap">
                  <a href=""> <i class="fa-solid fa-user icon"></i> حسابي</a>
                </li>
                <li class="main-tap">
                  <form action="./server.php" method='post'>
                    <button type="submit" class="" name="logout" href="">
                      <i class="fa-solid fa-power-off icon"></i>
                      تسجيل الخروج
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-8">
          <div class="main-head">
            <span class="title">الملف الشخصى</span>
          </div>
          <div class="main-box">
            <?php
            if (isset($_GET['success'])) {
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
              echo $_GET['success'];
              echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
              echo '</div>';
            };
            if (isset($_GET['error'])) {
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
              echo $_GET['error'];
              echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
              echo '</div>';
            }
            ?>
            <form action="./server.php" method="post" enctype='multipart/form-data'>
              <div class="input-group  mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user icon"></i></span>
                <input type="text" name="name" value="<?php echo $dataUser['name'] ?>" class="form-control" placeholder="الاسم">
              </div>
              <div class="input-group  mb-3">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input type="text" class="form-control" name="email" value="<?php echo $dataUser['email'] ?>" placeholder="البريد الالكتروني">
              </div>
              <div class="input-group  mb-3">
                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                <input type="text" class="form-control" name="phone" value="<?php echo $dataUser['phone'] ?>" placeholder="الجوال">
              </div>
              <div class="input-group  mb-3">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="كلمة السر الجديدة">
              </div>
              <div class="inp_holder">
                <label for="" class="login-label">الصورة الشخصية</label>
                <input type="file" class="login-inp form-control" name="image" />
              </div>
              <button type="submit" name="btn-update" class="form-btn">
                حفظ التغيرات
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- start footer -->
  <footer class="footer">
    <div class="bar"></div>
    <div class="footer-bottom">
      <div class="container text-center">
        جميع الحقوق محفوظة للموقع @ 2023
      </div>
    </div>
  </footer>
  <!-- end footer -->
  <!-- Js Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="front-assets/js/all.min.js"></script>
</body>

</html>