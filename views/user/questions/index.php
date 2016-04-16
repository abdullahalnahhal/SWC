<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?= $this->tmpl('user/general/head'); ?>
<body>
    <div id="wrapper">
        
        <?= $this->tmpl('user/general/nav-top') ?>
        <!-- /. NAV TOP  -->
        <?= $this->tmpl('user/general/nav-side') ?>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <?= $this->tmpl('user/general/page-map'); ?>
                <?= $this->tmpl('user/questions/content'); ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
        </div>
    <!-- /. WRAPPER  -->
    <?= $this->tmpl('user/general/footer'); ?>
    <!-- /. FOOTER  -->
    <?= $this->tmpl('user/general/foot'); ?>


</body>
</html>
