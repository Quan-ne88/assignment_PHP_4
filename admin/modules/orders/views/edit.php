<?php
getHeader("layout/header.php");
require "modules/orders/controllers/ordersController.php";
$id = isset($_GET["id"]) ? intval($_GET["id"]) : "";
$orderInfo = getOrderByID($id);
if (isset($_POST['editOrder'])) {
  updateOrder($_POST['fullname'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['status'], $id);
  $orderInfo = getOrderByID($id);
}
?>
<!--Main layout-->
<div id="wrapper">
  <?php require "layout/sidebar.php"; ?>
  <main id="mainWrapper">
    <h2 class="mainWrapper-heading">Quản lý đơn hàng</h2>
    <div class="container pt-4" id="main-content">
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-header">
              <span><i class="bi bi-table me-2"></i></span> Chỉnh sửa đơn hàng
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <div class="mx-auto container">
                  <form action="" id="edit-form" enctype="multipart/form-data" method="post">
                    <?php if (!empty($orderInfo)) {
                    ?>
                      <div class="mb-3">
                        <label for="fullname" class="form-label">Tên người đặt</label>
                        <input type="text" class="form-control" value="<?php echo $orderInfo['ho_va_ten']; ?>" id="fullname" name="fullname">
                        <?php echo form_error("fullname") ?>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?php echo $orderInfo['email']; ?>" id="email" name="email">
                        <?php echo form_error("email") ?>
                      </div>
                      <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" value="<?php echo $orderInfo['so_dien_thoai']; ?>" id="phone" name="phone">
                        <?php echo form_error("phone") ?>
                      </div>
                      <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" value="<?php echo $orderInfo['dia_chi']; ?>" id="address" name="address">
                        <?php echo form_error("address") ?>
                      </div>
                      <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select name="status" id="status" class="form-control">
                        <option value="1" <?php echo $select = (int)$orderInfo['trang_thai'] === 1 ? "selected" : ""; ?>>Đơn hàng mới ... </option>
                        <option value="2" <?php echo $select = (int)$orderInfo['trang_thai'] === 2 ? "selected" : ""; ?>>Chờ Xử Lí ... </option>
                          <option value="3" <?php echo $select = (int)$orderInfo['trang_thai'] === 3 ? "selected" : ""; ?>>Đang chuẩn bị hàng ... </option>
                          <option value="4" <?php echo $select = (int)$orderInfo['trang_thai'] === 4 ? "selected" : ""; ?>>Chờ Lấy Hàng ...</option>
                          <option value="5" <?php echo $select = (int)$orderInfo['trang_thai'] === 5 ? "selected" : ""; ?>>Đang Giao Hàng ... </option>
                          <option value="6" <?php echo $select = (int)$orderInfo['trang_thai'] === 6 ? "selected" : ""; ?>>Đã nhận hàng ✓ </option>
                          <option value="7" <?php echo $select = (int)$orderInfo['trang_thai'] === 7 ? "selected" : ""; ?>>Đã thanh toán </option>
                        </select>
                        <?php echo form_error("status") ?>
                      </div>
                      
                      <div class="mb-3">
                        <?php echo form_error("update") ?>
                        <?php echo notify("update") ?>
                      </div>
                      <div class="mb-3">
                        <input type="submit" value="Cập nhật" class="btn btn-primary" name="editOrder"><br><br>
                        <div><a  class="btn btn-primary" href="?mod=orders&act=main">Quay Lại </a></div>
                        
                      </div>
                    <?php } ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
<!--Main layout-->
<?php
getFooter("layout/footer.php")
?>