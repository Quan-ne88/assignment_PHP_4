<?php
require "thuvien/validation.php";
require "modules/users/models/usersModel.php";
function registerUser($username, $password, $email, $fullname, $cf_password)
{
  global $error, $notify;
  if (isset($_POST['btn-reg'])) {
    $error = array();
    $notify = array();
    // Check input fullname
    if (empty($_POST['fullname'])) {
      $error['fullname'] = 'Không được để trống họ tên';
    } else {
      $fullname = $_POST['fullname'];
    }
    // Check input username
    if (empty($_POST['username'])) {
      $error['username'] = 'Không được để trống tên đăng nhập';
    } else {
      if (!is_username($_POST['username'])) {
        $error['username'] = 'Tên đăng nhập không đúng định dạng';
      } else {
        $username = $_POST['username'];
      }
    }
    // Check input password
    if (empty($_POST['password'])) {
      $error['password'] = 'Không được để trống password';
    } else {
      if (!is_password($_POST['password'])) {
        $error['password'] = 'Mật khẩu không đúng định dạng';
      } else {
        $password = md5($_POST['password']);
      }
    }
    // Check re-password
    if (empty($_POST['cf_password'])) {
      $error['cf_password'] = 'Không được để trống password';
    } else {
      if (!is_match_password($_POST['cf_password'])) {
        $error['cf_password'] = 'Mật khẩu nhập lại không khớp';
      } else {
        $cf_password = md5($_POST['cf_password']);
      }
    }
    // Check input email
    if (empty($_POST['email'])) {
      $error['email'] = 'Không được để trống email';
    } else {
      if (!is_email($_POST['email'])) {
        $error['email'] = 'Email không đúng định dạng';
      } else {
        $email = $_POST['email'];
      }
    }
    // Set variable for roles
    # Final
    if (empty($error)) {
      if (!userExists($username, $email)) {
        $data = array(
          'ho_va_ten' => $fullname,
          'ten_dang_nhap' => $username,
          'email' => $email,
          'mat_khau' => $password,
          'ma_vai_tro' => 2,
          'kich_hoat' => 1
        );
        addUser($data);
        // Notify
        redirect_to("?mod=users&act=login");
        $notify['success'] = "Đăng ký thành công";
      } else {
        $error['account'] = "Email hoặc username đã tồn tại trên hệ thống";
      }
    }
  }
}
function loginUser($username, $password)
{
  global $error;
  if (isset($_POST['btn-login'])) {
    $error = array();
    // Check input password
    if (empty($_POST['password'])) {
      $error['password'] = 'Không được để trống password';
    } else {
      if (!is_password($_POST['password'])) {
        $error['password'] = 'Mật khẩu không đúng định dạng';
      } else {
        $password = md5($_POST['password']);
      }
    }
    // Check input username
    if (empty($_POST['username'])) {
      $error['username'] = 'Không được để trống username';
    } else {
      if (!is_username($_POST['username'])) {
        $error['username'] = 'Username không đúng định dạng';
      } else {
        $username = $_POST['username'];
      }
    }
    # Final
    if (empty($error)) {
      if (checkLogin($username, $password)) {
        $_SESSION['is_login'] = true;
        $_SESSION['user_login'] = $username;
        // Notify
        redirect_to("");
      } else if (checkAdminLogin($username, $password)) {
        $_SESSION['is_login'] = true;
        $_SESSION['admin_login'] = $username;
        // Notify
        redirect_to("admin");
      } else {
        $error['password'] = "Sai mật khẩu hoặc tài khoản đã ngưng hoạt động. Vui lòng kiểm tra lại!";
      }
    } else {
      $error['account'] = "Username không tồn tại trên hệ thống hoặc tài khoản này chưa được active";
    }
  }
}
function logoutUser()
{
  unset($_SESSION['is_login']);
  $checkRolesLogout = checkLogoutUser(setNameForUser());
  if ($checkRolesLogout) {
    unset($_SESSION['user_login']);
    redirect_to("?mod=users&act=login");
  } else {
    unset($_SESSION['admin_login']);
    redirect_to("?mod=users&act=login");
  }
}
function changePassword($password, $newPassword, $confirmPassword)
{
  global $error;
  if (isset($_POST['change-password'])) {
    $error = array();
    if (empty($password)) {
      $error['password'] = "Vui lòng nhập vào mật khẩu cũ";
    } else {
      if (!isExistPassword(setNameForUser(), md5($password))) {
        $error['password'] = "Mật khẩu không đúng với trên hệ thống!";
      } else {
        $password = md5($_POST['password']);
      }
    }
    if (empty($newPassword)) {
      $error['newPassword'] = "Vui lòng nhập vào mật khẩu mới";
    } else {
      if (!is_password($newPassword)) {
        $error['newPassword'] = "Mật khẩu không đúng định dạng";
      } else {
        $newPassword = md5($_POST['new-password']);
      }
    }
    if (empty($confirmPassword)) {
      $error['confirmPassword'] = 'Vui lòng nhập lại mật khẩu mới';
    } else {
      if (!is_match_password_client($confirmPassword, 'new-password')) {
        $error['confirmPassword'] = 'Mật khẩu nhập lại không khớp. Vui lòng nhập lại!';
      } else {
        $confirmPassword = md5($_POST['confirmPassword']);
      }
    }
    if (empty($error)) {
      $data = array(
        'mat_khau' => $newPassword
      );
      updatePassword(setNameForUser(), $data);
      redirect_to("?mod=users&act=accounts");
    } else {
      $error['failed'] = "Đổi mật khẩu thất bại";
    }
  }
}
function changeInfoUser($fullname)
{
  global $error, $notify;
  if (isset($_POST["change-info"])) {
    $error = array();
    $notify = array();
    // Check input fullname
    if (empty($fullname)) {
      $error['fullname'] = 'Không được để trống họ và tên';
    } else {
      $fullname = $_POST['fullname'];
    }
    # Final
    if (empty($error)) {
      $data = [
        'ho_va_ten' => $fullname,
      ];
      updateInfoUser(setNameForUser(), $data);
      $notify['update'] = "Cập nhật thông tin thành công";
    } else {
      $error['update'] = "Cập nhật thông tin thất bại";
    }
  }
}
function setStatusPayment($status)
{
  if (empty($status)) return;
  $status = (int)$status;
  $str = "";
  switch ($status) {
    case 1:
      $str = "Chờ Xử Lí ...";
      break;
    case 2:
      $str = "Chờ Lấy Hàng ...";
      break;
    case 3:
      $str = "Đang Giao Hàng ...";
      break;
    case 4:
      $str = "Đã nhận hàng ✓ ";
      break;
    default:
      $str = "Chờ thanh toán";
      break;
  }
  return $str;
}
