<?php
getHeader("layout/header.php");

?>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

h2 {
    color: #4CAF50;
    text-align: center;
    margin-top: 50px;
}

.order-info {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.order-info h3 {
    margin-top: 0;
    color: green;
}

.order-info p {
    line-height: 1.6;
}

.order-info img {
    max-width: 100%;
    height: auto;
}

.gtn {
    display: block;
    width: 200px;
    height: 50px;
    margin: 20px auto;
    background-color: #007bff;
    color: #FFFFFF;
    text-align: center;
    border-radius: 5px;
    line-height: 50px;
    font-size: 18px;
    text-decoration: none;
}

.gtn:hover {
    background-color: #45a049;
}
</style>
<?php
require "modules/checkout/models/checkoutModel.php";
echo "<h2>ㅤㅤĐặt Hàng Thành Công ✓</h2>";

function inHoaDon() {
    $donhang = danhsachdonhang();
    $iddonhang = $donhang['id'];
    $chitietdonhang = chitietdonhang($iddonhang);
?>
    <style>
        .order-info {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .order-info h3 {
            margin-top: 0;
        }
        .order-info p {
            margin: 5px 0;
        }
        .order-info img {
            max-width: 200px;
            height: auto;
        }
        .gtn {
    display: block;
    width: 200px;
    height: 50px;
    margin: 20px auto;
    background-color: #4CAF50;
    color: #FFFFFF; 
    text-align: center;
    border-radius: 5px; 
    line-height: 50px; 
    font-size: 18px; 
    text-decoration: none; 
}

.gtn:hover {
    background-color: #45a049; 
}

        @media (min-width: 768px) {
            .order-info {
                flex-direction: row;
                justify-content: space-between;
            }
        }
    </style>

    <div class='order-info'>
        <div>
            <h3>Thông Tin Đơn Hàng</h3></p><br>
            <p><strong>Mã khách hàng: </strong><?=$donhang['ma_khach_hang']?></p><br>
            <p><strong>Ngày Tạo: </strong><?=$donhang['tao_ngay']?></p><br>
            <p><strong>Tổng tiền: </strong><?=currency_format($chitietdonhang['don_gia'] * $chitietdonhang['so_luong'])?></p><br>
            <p><strong>Số Lượng: </strong><?=$chitietdonhang['so_luong']?></p><br>
        </div>
        <div>
            <h3>ㅤChi Tiết Giỏ Hàng</h3></p><br>
            
            <p><strong>ㅤㅤ</strong><img src="admin/assets/img/products/<?=$chitietdonhang['hinh_anh']?>" alt=''></p><br>
            <p><strong>Sản Phẩm: </strong><?=$chitietdonhang['ten']?></p><br>
        </div>
        <div>
<h3>Thông Tin Đặt Hàng </h3></p><br>
<p><strong>Người đặt hàng:</strong> <?=$donhang['ho_va_ten']?></p><br>
            <p><strong>Địa chỉ:</strong> <?=$donhang['dia_chi']?></p><br>
            <p><strong>Email:</strong> <?=$donhang['email']?></p><br>
            <p><strong>Số điện thoại:</strong> <?=$donhang['so_dien_thoai']?></p><br>
        </div>

        
    </div>
<?php
}

inHoaDon();
?>
<a href="index.php" class="gtn font-baloo">Tiếp Tục Mua Sắm</a>
<?php
getFooter("layout/footer.php");
?>