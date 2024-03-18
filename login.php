<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>الرئيسية</title>
  <!-- Normalize -->
  <link rel="stylesheet" href="front-assets/css/normalize.css" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="front-assets/css/bootstrap.rtl.min.css" />
  <!-- Main File Css  -->
  <link rel="stylesheet" href="front-assets/css/main.css" />
  <!-- Font Google -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>

<body>
  <!-- Start layout -->
  <section class="login_page">
    <div class="box-col d-flex flex-column justify-content-center py-xl-0">
      <form action="./server.php" method="post" class="form_content" enctype='multipart/form-data'>
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
        <img src="front-assets/img/logo.png" alt="logo" class="logo-form" />
        <h3 class="header_title">
          <div class="title">مرحبا بك</div>
          <div class="text">قم بتسجيل حسابك الخاص الان للحصول علي افضل تجربة ممكنه</div>
        </h3>
        <div class="row gap-3 ">
          <div class="col-12 ">
            <label for="" class="label">البريد الالكتروني</label>
            <div class="group-inp">
              <input type="text" placeholder="name@company.com" name="email" id="" class="inp">
              <div class="box">
                <img src="img/login/sms.svg" class="icon" alt="">
              </div>
            </div>
          </div>
          <div class="col-12 mb-4">
            <label for="" class="label">كلمة السر</label>
            <div class="group-inp">
              <input type="password" placeholder="أدخل كلمة المرور" name="password" id="" class="inp">
              <div class="box">
                <img src="img/login/eye.svg" class="icon" alt="">
              </div>
            </div>
          </div>

          <div class="col-12">
            <button type="submit" name="login" class="sub_btn btn btn-primary w-100">تسجيل الدخول</button>
          </div>
          <span class='text-center text'>
            ليس لديك حساب ؟ <a href="./register.php" class='text-primary'>سجل الان</a>
          </span>
        </div>
      </form>
    </div>
    <div class="box-col box-bg d-flex flex-column justify-content-between align-items-center gap-5 align-items-xl-start">
      <img src="front-assets/img/land-1.webp" alt="img-bg" class="bg" />
      <img src="front-assets/img/logo.png" alt="logo" class="logo-bg" />
      <div class="text-bg">
        <div class="title">
          مطعم الزعيم
        </div>
        <div class="p">
          اشهي المأكولات و الاطباق الشعبية
        </div>
      </div>
      <div class="text-bg-2">
        كل ماهو لذيذ
      </div>
    </div>
  </section>
  <!-- End layout -->
  <!-- Js Files -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</html>