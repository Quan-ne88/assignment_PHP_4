<?php
getHeader("layout/header.php");
require "modules/category/controllers/categoryController.php";

// Check if the delete button is clicked
if (isset($_GET['act']) && $_GET['act'] == 'delete' && isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    // Call a function to delete the category by its ID
    deleteCategory($categoryId);
}

$listCategory = getListCategory();
?>
<!--Main layout-->
<div id="wrapper">
    <?php require "layout/sidebar.php"; ?>
    <main id="mainWrapper">
        <h2 class="mainWrapper-heading">Quản lý danh mục</h2>
        <div class="container pt-4" id="main-content">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i></span> Danh sách danh mục
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>ID danh mục</th>
                                            <th>Tên danh mục</th>
                                            <th>Tạo ngày</th>
                                            <th colspan="3">Thao tác</th> <!-- Add one more column for the delete button -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($listCategory)) {
                                            foreach ($listCategory as $item) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $item['id'] ?></td>
                                                    <td><?php echo $item['tieu_de'] ?></td>
                                                    <td><?php echo $item['tao_ngay'] ?></td>
                                                    <td>
                                                        <a href="?mod=category&act=edit&id=<?php echo $item['id'] ?>" title="Sửa danh mục">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="?mod=category&act=add" title="Thêm danh mục">
                                                            <i class="fas fa-add"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="?mod=category&act=del&id=<?php echo $item['id'] ?>" title="Xóa danh mục">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
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
getFooter("layout/footer.php")
?>
