<?php
include './connect.php';
$orders = $connect->ordersTable();
// print_r($orders);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>المنتجات</title>
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

        <li class="list-item">
          <a href="users.php">
            <div>
              <i class="fa-solid fa-grip"></i>
              العملاء
            </div>
          </a>
        </li>
        <li class="list-item active">
          <a href="orders.php">
            <div>
              <i class="fa-solid fa-grip"></i>
              الطلبات
            </div>
          </a>
        </li>
        <li class="list-item ">
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
        <div class="large">الطلبات</div>
      </div>
      <div class="table-responsive">
        <table class="main-table">
          <thead>
            <tr>
              <th class='text-center'>
                #
              </th>
              <th class="text-center">العميل</th>
              <th class="text-center">المنتج</th>
              <th class="text-center">حالة الطلب</th>
              <th class="text-center">العمليات</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($orders as $order) {
              echo "<tr>";
              echo "<td class='text-center'>" . $order['id'] . "</td>";
              echo "<td class='text-center'>" . $order['userName'] . "</td>";
              echo "<td class='text-center'>" . $order['productName'] . "</td>";
              echo "<td>";
              if ($order['status'] === 'pending'){
                echo "<div class='btn-light-yellow'>انتظار</div>";
              }else if ($order['status'] === 'accepted'){
                echo "<div class='btn-light-green'>مقبول</div>";
              }else if ($order['status'] === 'refused'){
                echo "<div class='btn-light-red'>مرفوض</div>";
              }
            echo "</td>";
              echo "<td> <div class='d-flex justify-content-center gap-2 '>";

              if ($order['status'] === 'pending') {
                echo "
          <form action='server.php' method='post'>
              <input type='hidden' name='orderId' class='form-control' value='{$order['id']}'>
              <button type='submit' name='acceptOrder' class='btn btn-success btn-sm'>قبول</button>
          </form>
          <form action='server.php' method='post'>
              <input type='hidden' name='orderId' class='form-control' value='{$order['id']}'>
              <button type='submit' name='refuseOrder' class='btn btn-danger btn-sm'>رفض</button>
          </form>
      ";
              }

              echo "
      <button data-bs-toggle='modal' data-bs-target='#delete{$order['id']}'>
          <i class='fas fa-trash text-danger icon-table'></i>
      </button>
  </div>
  </div>
  </td>";
              echo "</tr>";
              echo "
      <div class='modal fade' id='delete{$order['id']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
                          <input type='hidden' name='orderId' class='form-control' value='{$order['id']}'>
                          <button type='submit' name='deleteOrder' class='btn btn-danger'>حذف</button>
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
    </div>
  </div>
  <!-- End layout -->
  <!-- Js Files -->
  <script src="admin-assets/js/bootstrap.bundle.min.js"></script>
  <script src="admin-assets/js/all.min.js"></script>
  <script src="admin-assets/js/main.js"></script>
</body>

</html>