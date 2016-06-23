<?php
/*
Template Name: Coupon
*/
$coupon = get_post_custom($_REQUEST['id']);
$sponsor = get_post($_REQUEST['id']);
$sponsor = (array) $sponsor;

get_header();
?>
<div id="blBody">
    <?php 
    //print_r($coupon);
    $logo = wp_get_attachment_image_src($coupon['logo'][0], 'full', '');

    ?>
    <div style="width:600px;margin: 35px auto;">
        <h3 style="font-size:18px;color:#05374a;margin:10px 0 35px 10px;">A Special Offer From <?php echo $sponsor['post_title']?></h3>

        <div style="clear:both"></div>

        <div style="border:1px #05374a dashed; background-color:#ffffff;padding:10px;margin:20px auto;height:auto;width:560px;"><?php echo $coupon['coupon'][0]?></div>

        <div class="coupon_additional" style="margin:10px 0 20px 10px;">
            <p style="font-size:13px;"><?php echo $coupon['additional_information'][0]?></p>
        </div>

        <a href="#" style="background:url('/template/images/print_button.png') no-repeat;width:75px; height:30px;float:right;margin:10px 10px 0 0 ;padding:0;" onclick="window.print()">&nbsp;</a>
        <a href="http://<?php echo $coupon['link'][0]?>" style="width:200px;font-family:Helvetica;color:#474747;padding-left:15px;margin-top:65px;" target="_blank"><h4 style="margin:10px 0 0 10px;padding:0;color:#05374a;font-style:italic;">Go to Our Sponsor's Website -></h4></a>


    </div>
</div>
<?php get_footer();




