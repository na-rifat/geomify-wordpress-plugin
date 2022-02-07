<div class="email-body"style="padding: 50px 15%;
    background-color: white;    
    border-bottom: 1px solid #ccc;    
    text-align: center;">
    <h3>Thank you for your request for Enterprise Quote!</h3>
    <h6>We will contact you as soon as possible.</h6>
    <table style="text-align: left;">
        <tr>
            <th>Email:</th>
            <td><?php echo $_POST['email'] ?></td>
        </tr>
        <tr>
            <th>First name:</th>
            <td><?php echo $_POST['first_name'] ?></td>
        </tr>
        <tr>
            <th>Last name:</th>
            <td><?php echo $_POST['last_name'] ?></td>
        </tr>
        <tr>
            <th>Office phone:</th>
            <td><?php echo $_POST['office_phone'] ?></td>
        </tr>
        <tr>
            <th>Mobile:</th>
            <td><?php echo $_POST['mobile'] ?></td>
        </tr>
    </table>
</div>


<div class="email-footer" style="
    background-color: white;
    padding: 50px 10%;
    text-align: center;">
    <p class="footer-p">
        <a href="<?php echo site_url( 'terms-of-use-privacy' ) ?>">User Terms</a> & <a
            href="<?php echo site_url( 'terms-of-use-privacy' ) ?>">Privacy Policy</a>
    </p>
    <div class="social-ico-holder" style="display: inline-block;
    margin: 20px 0;">
        <a href="" class="social-ico" target="_blank" style="border-radius: 50%;
    height: 25px;
    width: 30px;
    border: 2px solid #ccc;
    padding: 8px 6px 8px;
    margin: 0 10px;
    color: black;
    font-size: 18px;
    display: inline-block;"><img src="<?php echo geomify_imgfile( '/icons/twitter.png' ) ?>"
                style="height: 25px;width: 25px; margin-bottom: -5px; display: inline-block;"></a>
        <a href="" class="social-ico" target="_blank" style="border-radius: 50%;
    height: 25px;
    width: 30px;
    border: 2px solid #ccc;
    padding: 8px 6px 8px;
    margin: 0 10px;
    color: black;
    font-size: 18px;
    display: inline-block;"><img src="<?php echo geomify_imgfile( '/icons/linkedin.png' ) ?>"
                style="height: 25px;width: 25px; margin-bottom: -5px; display: inline-block;"></a>
        <a href="" class="social-ico" target="_blank" style="border-radius: 50%;
    height: 25px;
    width: 30px;
    border: 2px solid #ccc;
    padding: 8px 6px 8px;
    margin: 0 10px;
    color: black;
    font-size: 18px;
    display: inline-block;"><img src="<?php echo geomify_imgfile( '/icons/youtube.png' ) ?>"
                style="height: 25px;width: 25px; margin-bottom: -5px; display: inline-block;"></a>
        <a href="" class="social-ico" target="_blank" style="border-radius: 50%;
    height: 25px;
    width: 30px;
    border: 2px solid #ccc;
    padding: 8px 6px 8px;
    margin: 0 10px;
    color: black;
    font-size: 18px;
    display: inline-block;"><img src="<?php echo geomify_imgfile( '/icons/rss.png' ) ?>"
                style="height: 25px;width: 25px; margin-bottom: -5px; display: inline-block;"></a>
        <p class="footer-p">
            Copyright © Geomify Digital Twin by SANOY <?php echo date( 'Y', time() ) ?>
        </p>
    </div>