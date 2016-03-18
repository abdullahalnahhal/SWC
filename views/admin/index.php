<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->title = 'Free Bootstrap Admin Template' ?>
<?= $this->tmpl('admin/head'); ?>
<body>
    <div id="wrapper">
        
        <?= $this->tmpl('admin/nav-top') ?>
        <!-- /. NAV TOP  -->
        <?= $this->tmpl('admin/nav-side') ?>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <?= $this->tmpl('admin/page-map'); ?>
                <?= $this->tmpl('admin/content'); ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
        </div>
    <!-- /. WRAPPER  -->
    <?= $this->tmpl('admin/footer'); ?>
    <!-- /. FOOTER  -->
    <?= $this->tmpl('admin/foot'); ?>


</body>
</html>
