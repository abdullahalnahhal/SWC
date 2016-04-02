<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?= $this->tmpl('admin/general/head'); ?>
<body>
    <div id="wrapper">
        
        <?= $this->tmpl('admin/general/nav-top') ?>
        <!-- /. NAV TOP  -->
        <?= $this->tmpl('admin/general/nav-side') ?>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <?= $this->tmpl('admin/general/page-map'); ?>
                <?= $this->tmpl('admin/tracks/addtrk'); ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
        </div>
    <!-- /. WRAPPER  -->
    <?= $this->tmpl('admin/general/footer'); ?>
    <!-- /. FOOTER  -->
    <?= $this->tmpl('admin/general/foot'); ?>


</body>
</html>
