<?php 
 
 /*
Template Name: reset
*/

?>
<?php get_header(); ?>

<div id="mj-slidetitle">
  <div class="mj-subcontainer">
    <div class="mj-grid96">
      <h3>
        <?php the_title(); ?>
      </h3>
    </div>
  </div>
</div>
<div id="mj-featured1">
  <div class="mj-subcontainer">
    <div class="mj-grid96 breadcrumb">
      <div class="breadcrumbs mj-grid96 breadcrumb">
        <?php mjsimple_breadcrumb(); ?>
      </div>
    </div>
  </div>
</div>
<div id="primary">
  <div id="content" role="main">
    <div class="mj-subcontainer">
      <div id="mj-left" class="mj-grid16">
        <div class="moduletable mj-strip">
          <?php get_sidebar() ?>
        </div>
      </div>
      <div id="mj-contentarea" class="mj-grid80">
        <header class="entry-header">
          <h1 class="entry-title">
            <?php the_title(); ?>
          </h1>
        </header>
        <div class="entry-content">
          <p>Please enter the email address for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.</p>
          <?php 
                    global $user_identity, $user_ID;	
                    // If user is logged in or registered, show dashboard links in panel
                    if (is_user_logged_in()) 
                    { 
                ?>
          <div id="">
            <h3>You Are Already reset as a <?php echo $user_identity ?></h3>
            <a href="<?php echo wp_logout_url(get_permalink()); ?>" rel="nofollow" title="<?php  echo 'Log out';  ?>">
            <?php  echo 'Log out';  ?>
            </a> </div>
          <!-- /login -->
          <?php 
                    // Else if user is not logged in, show login and register forms
                    } 
                    else 
                    {	
                ?>
          <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
            <p>
              <label for="user_login" ><?php echo 'Username or E-mail:'; ?><br />
              <input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" tabindex="10" />
              </label>
            </p>
            <?php do_action('lostpassword_form'); ?>
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
            <p class="submit">
              <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e('Get New Password'); ?>" tabindex="100" />
            </p>
          </form>
          <?php 
                    } 
                ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
