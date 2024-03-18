<?php
include './connect.php';
$users = $connect->table("users");
// print_r($users);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>العملاء</title>
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
  <?php
  include 'admin-layout/navbar.php'
  ?>
  <div class="app-2">
    <div class="sidebar">
      <div class="tog-active d-none d-lg-block" data-tog="true" data-active=".app-2">
        <i class="fas fa-bars"></i>
      </div>
      <ul class="list">
        <li class="list-item ">
          <a href="dashboard.php">
            <div>
              <i class="fa-solid fa-grip"></i>
              الرئيسية
            </div>
          </a>
        </li>

        <li class="list-item active">
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
      <div class="main-title">
        <div class="small">الرئيسية</div>
        <div class="large">العملاء</div>
      </div>
      <div class="bar-obtions d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <div class="btn-holder">
            <button data-bs-toggle="modal" data-bs-target="#add" class="main-btn" style="padding: 10px 20px">
              إضافة <i class="fa-solid fa-plus"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="main-table">
          <thead>
            <tr>
              <th>
                #
              </th>
              <th>الصورة</th>
              <th>الاسم</th>
              <th>البريد الالكتروني</th>
              <th>رقم الهاتف</th>
              <th>العمليات</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($users as $user) {
              echo "<tr>";
              echo "<td>" . $user['id'] . "</td>";
              if (isset($user['image'])) {
                echo "<td><div class='user'><img src='./images/" . $user['image'] . "' alt='' /></div></td>";
              } else {
                echo "<td><div class='user'><img src='./front-assets/img/empty.jpg' alt='' /></div></td>";
              }
              echo "<td>" . $user['name'] . "</td>";
              echo "<td>" . $user['email'] . "</td>";
              echo "<td>" . $user['phone'] . "</td>";
              echo "<td>
              <div class='btn-holder d-flex align-items-center gap-3'>
                  <button data-bs-toggle='modal' data-bs-target='#edit{$user['id']}'>
                      <i class='fas fa-pen text-info icon-table'></i>
                  </button>
                  <button data-bs-toggle='modal' data-bs-target='#delete{$user['id']}'>
                      <i class='fas fa-trash text-danger icon-table'></i>
                  </button>
              </div>
          </td>";
              echo "</tr>";
              echo "<div class='modal fade' id='edit{$user['id']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <form action='server.php' method='post' enctype='multipart/form-data'>
                    <div class='modal-header'>
                      <h1 class='modal-title fs-5' id='exampleModalLabel'>تعديل العميل</h1>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                      <div class='row'>
                        <div class='col-12 col-md-4'>
                          <div class='inp-holder'>
                            <label for=''>الاسم</label>
                            <input type='text' name='name' class='form-control' value='{$user['name']}' id=''>
                            <input type='hidden' name='userId' class='form-control' value='{$user['id']}'  id=''>
                          </div>
                        </div>
                        <div class='col-12 col-md-4'>
                          <div class='inp-holder'>
                            <label for=''>البريد الالكتروني</label>
                            <input type='text' class='form-control' name='email' value='{$user['email']}' id=''>
                          </div>
                        </div>
                        <div class='col-12 col-md-4'>
                          <div class='inp-holder'>
                            <label for=''>رقم الهاتف</label>
                            <input type='text' class='form-control' name='phone' value='{$user['phone']}' id=''>
                          </div>
                        </div>
                        <div class='col-12 col-md-4'>
                          <div class='inp-holder'>
                            <label for=''>الرقم السري</label>
                            <input type='text' class='form-control' name='password'  id=''>
                          </div>
                        </div>
                        <div class='col-12 col-md-4'>
                          <div class='inp-holder'>
                            <label for=''>الصورة</label>
                            <input type='file' class='form-control' name='image'  id=''>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>الغاء</button>
                      <button type='submit' name='editUser' class='btn btn-primary'>حفظ</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>";
              echo "
            <div class='modal fade' id='delete{$user['id']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h1 class='modal-title fs-5' id='exampleModalLabel'>حذف العميل</h1>
                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                  <h6 class='text-center'>هل انت متأكد من الحذف؟</h6>
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>الغاء</button>
                  <form action='server.php' method='post'>
                  <input type='hidden' name='userId' class='form-control' value='{$user['id']}'  id=''>
                  <button type='submit' name='deleteUser' class='btn btn-danger'>حذف</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
            ";
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- Modal-Add -->
      <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="server.php" method="post" enctype="multipart/form-data">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">اضافة العميل</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-12 col-md-4">
                    <div class="inp-holder">
                      <label for="">الاسم</label>
                      <input type="text" name='name' class="form-control" name="" id="">
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="inp-holder">
                      <label for="">البريد الالكتروني</label>
                      <input type="text" class="form-control" name="email" id="">
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="inp-holder">
                      <label for="">رقم الهاتف</label>
                      <input type="text" class="form-control" name="phone" id="">
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="inp-holder">
                      <label for="">الرقم السري</label>
                      <input type="text" class="form-control" name="password" id="">
                    </div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="inp-holder">
                      <label for="">الصورة</label>
                      <input type="file" class="form-control" name="image" id="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <button type="submit" name="addUser" class="btn btn-primary">حفظ</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End layout -->
  <!-- Js Files -->
  <script src="admin-assets/js/bootstrap.bundle.min.js"></script>
  <script src="admin-assets/js/all.min.js"></script>
  <script src="admin-assets/js/main.js"></script>
</body>

</html>