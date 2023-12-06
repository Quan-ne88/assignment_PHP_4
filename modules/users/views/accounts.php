<?php
getHeader("layout/header.php");
require "modules/users/controllers/userController.php";
if (isset($_POST['btn-logout'])) {
  logoutUser();
}
if (!empty(setNameForUser())) {
  $userInfo = getUserByUsername();
  $userID  = (int)$userInfo['id'];
  if (isset($userID)) {
    $listOrders = getListOrdersForUser($userID);
  }
  if (isset($_POST['change-password'])) {
    changePassword($_POST['password'], $_POST['new-password'], $_POST['confirm-password']);
    $userInfo = getUserByUsername();
  }
  if (isset($_POST['change-info'])) {
    changeInfoUser($_POST['fullname']);
    $userInfo = getUserByUsername();
  }
}
?>
<div class="container py-3">
  <!-- Account Page -->
  <section class="account">
    <div class="account-wrapper">
      <h3 class="account-wrapper__heading">Thông tin tài khoản</h3>
      <ul>
        <?php if (empty($userInfo)) {
        ?>
          <li>
            <a href="?mod=users&act=login">Đăng nhập</a>
          </li>
          <li><a href="?mod=users&act=register">Đăng ký</a></li>
        <?php } ?>
      </ul>
      <div class="account-info mt-2">
        <?php if (!empty($userInfo)) {
        ?>
          <p class="account-name">Họ và tên: <?php echo $userInfo['ho_va_ten'] ?></p>
          <p class="account-name">Tên đăng nhập: <?php echo $userInfo['ten_dang_nhap'] ?></p>
          <p class="account-email">Email: <?php echo $userInfo['email'] ?></p>
          <p class="account-phone">Trạng thái tài khoản: <?php echo $status = (int)$userInfo['kich_hoat'] === 1 ? "Kích hoạt" : "Ngừng hoạt động"; ?></p>
          <div class="account-btn">
            <form action="" method="post" class="account-btn__logout">
              <button type="submit" class="btn btn-danger" name="btn-logout" value="logout">Đăng xuất</button>
            </form>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="account-changed">
      <?php if (!empty($userInfo)) {
      ?>
        <form action="" class="account-form" method="post">
          <h3 class="account-form__heading">Cập nhật thông tin</h3>
          <div class="input-group mb-3 d-block">
            <label for="fullname" class="form-label" id="label">Họ và tên</label>
            <input id="fullname" type="text" placeholder="Họ và tên" name="fullname" value="<?php echo $fullname = $userInfo['ho_va_ten'] ?>" class="form-control" />
            <?php echo form_error("fullname") ?>
          </div>
          <div class="input-group mb-3 d-block">
            <label for="username" class="form-label" id="label">Tên đăng nhập</label>
            <input id="username" type="text" placeholder="Tên đăng nhập" name="username" value="<?php echo $username = $userInfo['ten_dang_nhap'] ?>" disabled style="cursor: not-allowed;" class="form-control" />
          </div>
          <div class="input-group mb-3 d-block">
            <label for="email" class="form-label" id="label">Email</label>
            <input id="email" type="text" placeholder="Email" name="email" value="<?php echo $email = $userInfo['email'] ?>" disabled style="cursor: not-allowed;" class="form-control" />
          </div>
          <div class="input-group d-block">
            <?php echo form_error("update") ?>
            <?php echo notify("update") ?>
          </div>
          <button type="submit" class="btn btn-primary" name="change-info">Cập nhật</button>
        </form>
      <?php } ?>
    </div>
    <div class="account-changed">
      <?php if (!empty($userInfo)) {
      ?>
        <form action="" class="account-form" method="post">
          <h3 class="account-form__heading">Đổi mật khẩu</h3>
          <div class="input-group mb-3 d-block">
            <label for="password" class="form-label">Mật khẩu cũ</label>
            <input id="password" type="password" placeholder="Mật khẩu" name="password" class="form-control" />
            <?php echo form_error("password") ?>
          </div>
          <div class="input-group mb-3 d-block">
            <label for="new-password" class="form-label">Mật khẩu mới</label>
            <input id="new-password" type="password" placeholder="Mật khẩu mới" name="new-password" class="form-control" />
            <?php echo form_error("newPassword") ?>
          </div>
          <div class="input-group mb-3 d-block">
            <label for="confirm-password" class="form-label">Xác nhận mật khẩu</label>
            <input id="confirm-password" type="password" placeholder="Xác nhận mật khẩu" name="confirm-password" class="form-control" />
            <?php echo form_error("confirmPassword") ?>
          </div>
          <button type="submit" class="btn btn-secondary" name="change-password">Cập nhật</button>
        </form>
      <?php } ?>
    </div>
  </section>
  <!-- Orders Page -->
  <section class="orders">
    <div class="cart-wrapper">
      <div class="section-top">
        <h2 class="section-top__heading">Đơn hàng của bạn</h2>
      </div>
      <table class="table table-striped" id="table" style="margin-bottom: 2rem;">
        <thead>
          <tr>
            <th>ID đơn hàng</th>
            <th>Hình SP</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Số Điện Thoại</th>
            <th>Email</th>
            <th>Địa Chỉ</th>
            <th>Trạng thái</th>
            <th>Ngày đặt hàng</th>
            <th></th>
            
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($listOrders) && !empty($userInfo)) {
            foreach ($listOrders as $item) {
          ?>
          
              <tr>
                <td><?php echo $item['id'] ?></td>
                <td><img src="admin/assets/img/products/<?php echo $item['hinh_anh']  ?>" alt="" style="width: 150px; height: 150px; object-fit: cover;"></td>
                <td><?php echo currency_format($item['don_gia']) ?></td>
                <td><?php echo $item['so_luong'] ?></td>
                <td><?php echo $item['so_dien_thoai'] ?></td>
                <td><?php echo $item['email'] ?></td>
                <td><?php echo $item['dia_chi'] ?></td>
                <td><?php echo setStatusPayment($item['trang_thai']) ?></td>
                <td><?php echo $item['tao_ngay'] ?></td>
                
              </tr>
            <?php  }
          } else {
            ?>
            <p>Người dùng này chưa mua sản phẩm nào!</p>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
<?php
getFooter("layout/footer.php")
?>