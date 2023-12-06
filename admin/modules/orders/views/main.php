<?php
getHeader("layout/header.php");
require "modules/orders/controllers/ordersController.php";
$listOrders = getListOrders();
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
              <span><i class="bi bi-table me-2"></i></span> Danh sách đơn hàng
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-striped data-table" style="width: 100%">
                  <thead>
                    <tr>
                      <th>ID đơn hàng</th>       
                      <th>Ngày đặt</th>
                      <th>Họ và tên</th>
                      <th>Email</th>
                      <th>Trạng thái</th>
                      <th colspan="2">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($listOrders)) {
                      foreach ($listOrders as $item) {
                    ?>
                        <tr>
                          <td><?php echo $item['id'] ?></td>
                          <td><?php echo $item['tao_ngay'] ?></td>
                          <td><?php echo $item['ho_va_ten'] ?></td>
                          <td><?php echo $item['email'] ?></td>
                          <td><?php echo getStatusPayment($item['trang_thai']) ?></td>
                          <td>
                            <a href="?mod=orders&act=detail&id=<?php echo $item['id'] ?>" class="btn btn-md mb-1 btn-primary">Chi tiết đơn hàng</a>
                            <a href="?mod=orders&act=edit&id=<?php echo $item['id'] ?>" class="btn btn-md btn-warning">Chỉnh sửa đơn hàng</a>
                          </td>
                        </tr>
                    <?php  }
                    } ?>
                  </tbody>
                </table>
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
getFooter("layout/footer.php");
?>