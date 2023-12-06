<?php
require "modules/orders/models/ordersModel.php";
function getStatusPayment($status)
{
  if (empty($status)) return;
  $str = "";
  $status = intval($status);
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
function updateOrder($fullname, $email, $phone, $address, $status, $id)
{
  global $error, $notify;
  if (isset($_POST['editOrder'])) {
    $error = [];
    $notify = [];
    if (empty($fullname)) {
      $error['fullname'] = 'Không được để trống họ tên';
    } else {
      $fullname = htmlspecialchars($fullname);
    }
    if (empty($address)) {
      $error['address'] = 'Không được để trống địa chỉ';
    } else {
      $address = htmlspecialchars($address);
    }
    if (empty($email)) {
      $error['email'] = 'Không được để trống email';
    } else {
      if (!is_email($email)) {
        $error['email'] = 'Email không đúng định dạng';
      } else {
        $email = htmlspecialchars($email);
      }
    }
    if (empty($phone)) {
      $error['phone'] = 'Không được để trống số điện thoại';
    } else {
      if (!is_tel($phone)) {
        $error['phone'] = 'Số điện thoại không đúng định dạng';
      } else {
        $phone = htmlspecialchars($phone);
      }
    }
    if (empty($status)) {
      $error['status'] = 'Không được để trống trạng thái';
    } else {
      $status = htmlspecialchars($status);
    }
    if (empty($error)) {
      $data  = [
        'ho_va_ten' => $fullname,
        'email' => $email,
        'so_dien_thoai' => $phone,
        'dia_chi' => $address,
        'trang_thai' => $status,
      ];
      updateOrderToDB($data, $id);
      $notify['update'] = "Cập nhật thành công";
    } else {
      $error['update'] = "Cập nhật thất bại";
    }
  }
  
}
