<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->title = 'Free Bootstrap user Template' ?>
<?= $this->tmpl('user/head'); ?>
<body>
    <div id="wrapper">
        
        <?= $this->tmpl('user/nav-top') ?>
        <!-- /. NAV TOP  -->
        <?= $this->tmpl('user/nav-side') ?>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <?= $this->tmpl('user/page-map'); ?>
                <?= $this->tmpl('user/content'); ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
        </div>
    <!-- /. WRAPPER  -->
    <?= $this->tmpl('user/footer'); ?>
    <!-- /. FOOTER  -->
    <?= $this->tmpl('user/foot'); ?>


</body>
</html>
