<?php include __DIR__ . '/../header.php'; ?>

<div class="content">
    <div class="con-head">
        <span class="update fr"><?= Version ?></span>
    </div>
    <div class="con-body">
        <!--成功安装信息-->
        <div class="State">
            <h2><?= lang('安装成功，欢迎您使用 远丰IM'); ?> <?= Version; ?></h2>
            <h4><?= lang('请牢记您的管理员账号和密码用于网站后台登陆'); ?></h4>
            <h4><?= lang('强烈建议您在安装完毕后,请删除 install 文件夹及内容，以免存在被他人重装的风险！'); ?></h4>
            <li><?= lang('管理员账号：'); ?><span class="name"><?= $_GET['admin_user'] ?></span></li>
        </div>
        <div class="btn mt85">
            <a class="agree-btn m264 fl" href="<?= url('admin/index/index'); ?>"><?= lang('进入管理系统'); ?></a> <a class="agree-btn3 fl" style="display: none;" href="<?= url('') ?>"><?= lang('一键安全删除目录'); ?></a>
        </div>
        <a class="state-bg bg-img fr"></a>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>
