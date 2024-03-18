<?php


require('./connect.php');
$connection = $connect->getConnection();
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];
  $image = $_FILES['image'];

  $arr = [];

  if (!$name) {
    $arr[] = 'يرجي مليء  حقل الاسم<br>';
  }
  if (!$email) {
    $arr[] = 'يرجي مليء  حقل البريد الالكتروني<br>';
  }
  if (!$password) {
    $arr[] = 'يرجي مليء  حقل كلمة السر<br>';
  }
  if (!$phone) {
    $arr[] = 'يرجي مليء حقل الهاتف <br>';
  }

  if (!empty($arr)) {
    $error_messages = implode(',', $arr);
    header("location:register.php?error=$error_messages");
    exit();
  }

  $imgEx = strtolower(explode('.', $image['name'])[1]);
  $Extensions = ['png', 'jpg'];
  if (!in_array($imgEx, $Extensions)) {
    header('location: register.php?error= يجب ان يكون الملف صورة');
    exit();
  }

  if (!is_dir('images')) {
    mkdir('images');
  }

  $imgName = $image['name'];

  move_uploaded_file($image['tmp_name'], "images/$imgName");
  $query = "insert into users (name,type,email,phone,password,image) values(?, ?, ?, ?, ?, ?)";
  $sqlQuery = $connection->prepare($query);

  $regex = "/^.{5,9}$/";

  if (preg_match($regex, $password)) {
    $hashPass = password_hash($password, PASSWORD_DEFAULT);
    $response =  $sqlQuery->execute([$name, 'user', $email, $phone, $hashPass, $image['name']]);
  } else {
    header('location:register.php?error=كلمة السر يجب ان تكون اكبر من 4  و اقل من 10 حروف');
    exit();
  }

  if ($response) {
    header('location:login.php?success=تم اضافة العميل بنجاح');
    exit();
  } else {
    header('location:register.php?error=هنالك خطأ');;
    exit();
  }
}


if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!$email || !$password) {
    header("location:login.php?error=يرجي مليء حقل كلمة السر و البريد الالكتروني ");
    exit();
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("location:login.php?error=يرجي كتابة حقل البريد الالكتروني مشكل صحيح ");
    exit();
  }
  $query = "select * from users where email= ?";
  $sqlQuery = $connection->prepare($query);
  $sqlQuery->execute([$email]);
  $data = $sqlQuery->fetch(PDO::FETCH_ASSOC);

  if ($data) {
    if ($data['type'] === 'user') {
      if (password_verify($password, $data['password'])) {
        $_SESSION['userId'] = $data['id'];
        echo $_SESSION['userId'];
        header("location:profile.php");
        exit();
      } else {
        header("location:login.php?error=خطأ في  كلمة السر");
        exit();
      }
    }
    if ($data['type'] === 'admin') {
      if ($password == $data['password']) {
        $_SESSION['userId'] = $data['id'];
        echo $_SESSION['userId'];

        header("location:dashboard.php");
        exit();
      } else {
        header("location:login.php?error=خطأ في  كلمة السر");
        exit();
      }
    }
  } else {
    header("location:login.php?error=خطأ في البريد او كلمة السر");
    exit();
  }
}


if (isset($_POST['btn-update'])) {
  $userId = $_SESSION['userId'];

  if (!empty($_POST['name'])) {
    $name = $_POST['name'];
    $query = "update users set name= ? where id = $userId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$name]);
  }
  if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $query = "update users set email= ? where id = $userId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$email]);
  }
  if (!empty($_POST['phone'])) {
    $phone = $_POST['phone'];
    $query = "update users set phone= ? where id = $userId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$phone]);
  }
  if (!empty($_POST['password'])) {

    $password = $_POST['password'];
    $regex = "/^.{5,9}$/";
    if (preg_match($regex, $password)) {
      $hashPass = password_hash($password, PASSWORD_DEFAULT);
      $query = "update users set password= ? where id = $userId ";
      $sqlQuery = $connection->prepare($query);
      $response =  $sqlQuery->execute([$hashPass]);
    } else {
      header('location:profile.php?error=كلمة السر يجب ان تكون اكبر من 4  و اقل من 10 حروف');
      exit();
    }
  }
  if (!empty($_POST['password'])) {
    $password = $_POST['password'];
    $regex = "/^.{5,9}$/";

    if (preg_match($regex, $password)) {
      $hashPass = password_hash($password, PASSWORD_DEFAULT);
      $query = "UPDATE users SET password = ? WHERE id = ?";
      $sqlQuery = $connection->prepare($query);
      $response = $sqlQuery->execute([$hashPass, $userId]);
    } else {
      header('location:profile.php?error=كلمة السر يجب ان تكون اكبر من 4  و اقل من 10 حروف');
      exit();
    }
  }

  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image'];
    $imgEx = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $extensions = ['png', 'jpg'];

    if (!in_array($imgEx, $extensions)) {
      header('location:profile.php?error= يجب ان يكون الملف صورة');
      exit();
    }

    if (!is_dir('images')) {
      mkdir('images');
    }

    $imgName = $image['name'];
    move_uploaded_file($image['tmp_name'], "images/$imgName");

    $query = "update users set image = ? where id = ?";
    $sqlQuery = $connection->prepare($query);
    $response = $sqlQuery->execute([$imgName, $userId]);
  }
  if ($response) {
    header('location:profile.php?success=تم تحديث بيانات العميل بنجاح');
    exit();
  } else {
    header('location:profile.php?error=هنالك خطأ');;
    exit();
  }
}


if (isset($_POST['addUser'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];
  $image = $_FILES['image'];

  $arr = [];

  if (!$name) {
    $arr[] = 'يرجي مليء  حقل الاسم<br>';
  }
  if (!$email) {
    $arr[] = 'يرجي مليء  حقل البريد الالكتروني<br>';
  }
  if (!$password) {
    $arr[] = 'يرجي مليء  حقل كلمة السر<br>';
  }
  if (!$phone) {
    $arr[] = 'يرجي مليء حقل الهاتف <br>';
  }

  if (!empty($arr)) {
    $error_messages = implode(',', $arr);
    header("location:users.php?error=$error_messages");
    exit();
  }

  $imgEx = strtolower(explode('.', $image['name'])[1]);
  $Extensions = ['png', 'jpg'];
  if (!in_array($imgEx, $Extensions)) {
    header('location: users.php?error= يجب ان يكون الملف صورة');
    exit();
  }

  if (!is_dir('images')) {
    mkdir('images');
  }

  $imgName = $image['name'];

  move_uploaded_file($image['tmp_name'], "images/$imgName");
  $query = "insert into users (name,type,email,phone,password,image) values(?, ?, ?, ?, ?, ?)";
  $sqlQuery = $connection->prepare($query);

  $regex = "/^.{5,9}$/";

  if (preg_match($regex, $password)) {
    $hashPass = password_hash($password, PASSWORD_DEFAULT);
    $response =  $sqlQuery->execute([$name, 'user', $email, $phone, $hashPass, $image['name']]);
  } else {
    header('location:register.php?error=كلمة السر يجب ان تكون اكبر من 4  و اقل من 10 حروف');
    exit();
  }

  if ($response) {
    header('location:users.php?success=تم اضافة العميل بنجاح');
    exit();
  } else {
    header('location:users.php?error=هنالك خطأ');;
    exit();
  }
}

if (isset($_POST['addProduct'])) {
  $name = $_POST['name'];
  $desc = $_POST['desc'];
  $price = $_POST['price'];
  $image = $_FILES['image'];

  $errors = [];

  if (empty($name)) {
    $errors[] = 'يرجى ملء حقل الاسم<br>';
  }
  if (empty($desc)) {
    $errors[] = 'يرجى ملء حقل الوصف<br>';
  }
  if (empty($price)) {
    $errors[] = 'يرجى ملء حقل السعر<br>';
  } elseif (!is_numeric($price)) {
    $errors[] = 'يرجى ملء حقل السعر رقم<br>';
  }

  if (empty($errors)) {
    if (isset($_FILES['image'])) {
      $imgEx = strtolower(explode('.', $image['name'])[1]);
      $Extensions = ['png', 'jpg', 'jfif'];
      if (!in_array($imgEx, $Extensions)) {
        header('location: products.php?error= يجب ان يكون الملف صورة');
        exit();
      }

      if (!is_dir('images')) {
        mkdir('images');
      }

      $imgName = $image['name'];

      move_uploaded_file($image['tmp_name'], "images/$imgName");
    }


    $query = "INSERT INTO products (name, `desc`, price, image) VALUES (?, ?, ?, ?)";
    $sqlQuery = $connection->prepare($query);
    $response = $sqlQuery->execute([$name, $desc, $price, $image['name']]);

    if ($response) {
      header('location: products.php?success=تمت إضافة المنتج بنجاح');
      exit();
    } else {
      header('location: products.php?error=حدث خطأ أثناء إضافة المنتج');
      exit();
    }
  } else {
    $errorString = implode("<br>", $errors);
    header("location: products.php?error=$errorString");
    exit();
  }
}
if (isset($_POST['addOrder'])) {
  $product = $_POST['productId'];
  $user = $_POST['userId'];

  $query = "INSERT INTO orders (user_id , product_id , status) VALUES (?, ?, ?)";
  $sqlQuery = $connection->prepare($query);
  $response = $sqlQuery->execute([$user, $product, 'pending']);

  if ($response) {
    header('location: home.php?success=تمت إضافة المنتج بنجاح للعرية');
    exit();
  } else {
    header('location: home.php?error=حدث خطأ أثناء إضافة المنتج');
    exit();
  }
}

if (isset($_POST['editUser'])) {
  $userId = $_POST['userId'];

  if (!empty($_POST['name'])) {
    $name = $_POST['name'];
    $query = "update users set name= ? where id = $userId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$name]);
  }
  if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $query = "update users set email= ? where id = $userId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$email]);
  }
  if (!empty($_POST['phone'])) {
    $phone = $_POST['phone'];
    $query = "update users set phone= ? where id = $userId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$phone]);
  }
  if (!empty($_POST['password'])) {

    $password = $_POST['password'];
    $regex = "/^.{5,9}$/";
    if (preg_match($regex, $password)) {
      $hashPass = password_hash($password, PASSWORD_DEFAULT);
      $query = "update users set password= ? where id = $userId ";
      $sqlQuery = $connection->prepare($query);
      $response =  $sqlQuery->execute([$hashPass]);
    } else {
      header('location:users.php?error=كلمة السر يجب ان تكون اكبر من 4  و اقل من 10 حروف');
      exit();
    }
  }
  if (!empty($_POST['password'])) {
    $password = $_POST['password'];
    $regex = "/^.{5,9}$/";

    if (preg_match($regex, $password)) {
      $hashPass = password_hash($password, PASSWORD_DEFAULT);
      $query = "UPDATE users SET password = ? WHERE id = ?";
      $sqlQuery = $connection->prepare($query);
      $response = $sqlQuery->execute([$hashPass, $userId]);
    } else {
      header('location:users.php?error=كلمة السر يجب ان تكون اكبر من 4  و اقل من 10 حروف');
      exit();
    }
  }

  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image'];
    $imgEx = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $extensions = ['png', 'jpg'];

    if (!in_array($imgEx, $extensions)) {
      header('location:users.php?error= يجب ان يكون الملف صورة');
      exit();
    }

    if (!is_dir('images')) {
      mkdir('images');
    }

    $imgName = $image['name'];
    move_uploaded_file($image['tmp_name'], "images/$imgName");

    $query = "update users set image = ? where id = ?";
    $sqlQuery = $connection->prepare($query);
    $response = $sqlQuery->execute([$imgName, $userId]);
  }
  if ($response) {
    header('location:users.php?success=تم تحديث بيانات العميل بنجاح');
    exit();
  } else {
    header('location:users.php?error=هنالك خطأ');;
    exit();
  }
}

if (isset($_POST['editProduct'])) {
  $productId = $_POST['productId'];

  if (!empty($_POST['name'])) {
    $name = $_POST['name'];
    $query = "update products set name= ? where id = $productId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$name]);
  }
  if (!empty($_POST['desc'])) {
    $desc = $_POST['desc'];
    $query = "update products set `desc`= ? where id = $productId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$desc]);
  }
  if (!empty($_POST['price'])) {
    $price = $_POST['price'];
    $query = "update products set price= ? where id = $productId ";
    $sqlQuery = $connection->prepare($query);
    $response =  $sqlQuery->execute([$price]);
  }
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image'];
    $imgEx = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $extensions = ['png', 'jpg'];

    if (!in_array($imgEx, $extensions)) {
      header('location:products.php?error= يجب ان يكون الملف صورة');
      exit();
    }

    if (!is_dir('images')) {
      mkdir('images');
    }

    $imgName = $image['name'];
    move_uploaded_file($image['tmp_name'], "images/$imgName");

    $query = "update products set image = ? where id = ?";
    $sqlQuery = $connection->prepare($query);
    $response = $sqlQuery->execute([$imgName, $productId]);
  }
  if ($response) {
    header('location:products.php?success=تم تحديث بيانات العميل بنجاح');
    exit();
  } else {
    header('location:products.php?error=هنالك خطأ');;
    exit();
  }
}

if (isset($_POST['deleteUser'])) {
  $userId = $_POST['userId'];
  $connect->deleteId('users', "$userId");
  header('location:users.php?success=تم حذف العميل بنجاح');
  exit();
}
if (isset($_POST['deleteProduct'])) {
  $productId = $_POST['productId'];
  $connect->deleteId('products', "$productId");
  header('location:products.php?success=تم حذف المنتج بنجاح');
  exit();
}
if (isset($_POST['deleteOrder'])) {
  $orderId = $_POST['orderId'];
  $connect->deleteId('orders', "$orderId");
  header('location:orders.php?success=تم حذف الطلب بنجاح');
  exit();
}
if (isset($_POST['acceptOrder'])) {
  $orderId = $_POST['orderId'];
  $query = "update orders set status = ? where id = ?";
  $sqlQuery = $connection->prepare($query);
  $response = $sqlQuery->execute(['accepted', $orderId]);
  header('location:orders.php?success=تم قبول الطلب بنجاح');
  exit();
}
if (isset($_POST['refuseOrder'])) {
  $orderId = $_POST['orderId'];
  $query = "update orders set status = ? where id = ?";
  $sqlQuery = $connection->prepare($query);
  $response = $sqlQuery->execute(['refused', $orderId]);
  header('location:orders.php?success=تم رفض الطلب بنجاح');
  exit();
}

if (isset($_POST['logout'])) {
  $logout = $_POST['logout'];
  session_destroy();
  header('location:login.php');
  exit();
}
