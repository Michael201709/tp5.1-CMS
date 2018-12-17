<?php include __DIR__ . '/../header.php'; ?>

<!--安装con-->
<div class="content">
    <div class="con-head">
        <span class="update fr"><?= Version; ?></span>
    </div>
    <div class="con-body">
        <div class="step-con">
            <!--步骤-->
            <div class="step-box ">
                <span class="step-num  bg-img s1_on fl"></span> <span class="step-num  bg-img s2_on fl"></span> <span class="step-num  bg-img s3_on fl"></span>
            </div>
        </div>
        <div class="clear"></div>
        <div class="con-word install_info" id="install_info">
        
        </div>
        <div class="btn">
            <a class="agree-btn disabled next">正在安装系统</a>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>

<script type="text/javascript" src="/static/js/jquery.js"></script>
<script type='text/javascript'>
    //更新进度条
    function update_progress(obj) {
        if (obj.isError == true) {
            $(".install_info").append("<li><em class=\"bg-img no\"></em>" + obj.message + "</li>");
            
            $(".next").removeAttr("disabled").removeClass("agree-btn disabled").addClass("agree-btn3").text("重新安装");
            $(".next").attr("href", "javascript:location.reload()");
        } else {
            $(".install_info").append("<li><em class=\"bg-img ok\"></em>" + obj.message + "</li>");
            $(".next").text("正在安装系统(" + obj.percent + "%)");
            $(".install_info").scrollTop(9999999);
        }
        
        if (obj.percent == 100) {
            $(".next").removeAttr("disabled").removeClass("agree-btn disabled").addClass("agree-btn3").text("完成安装").attr("href", '<?= url('install/index/setup4') ?>?admin_user=' + obj.admin_user);
        }
    }
</script>
<?php
install_sql();
?>
</body>
</html>

