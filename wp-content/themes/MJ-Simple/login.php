<?php 
 /*
Template Name: login
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
          <?php 
                    	global $user_identity, $user_ID;	
                        	// If user is logged in or registered, show dashboard links in panel
                    	if (is_user_logged_in()) 
                    	{ 	
                	?>
          <div id="">
            <h3>Welcome back <?php echo $user_identity ?></h3>
            <a href="<?php echo wp_logout_url(get_permalink()); ?>" rel="nofollow" title="<?php echo 'Log out'; ?>">
            <?php  echo 'Log out';  ?>
            </a> </div>
          <!-- /login -->
          <?php 
                        // Else if user is not logged in, show login and register forms
                        } 
                        else 
                        {	
                    ?>
          <div id="mj-content">
            <div class="login">
              <form class="clearfix" action="<?php  echo home_url(); ?>/wp-login.php" method="post">
                <fieldset>
                <div class="login-fields">
                  <label class="" for="username" id="username-lbl">User Name</label>
                  <input class="field" type="text" name="log" id="log" value="<?php echo esc_html(stripslashes($user_login), 1) ?>" size="23" />
                </div>
                <div class="login-fields">
                  <label class="" for="password" id="password-lbl">Password</label>
                  <input class="field" type="password" name="pwd" id="pwd" size="23" />
                </div>
                <div class="login-fields">
                  <label for="remember" id="remember-lbl">Remember me</label>
                  <input type="checkbox" alt="Remember me" value="yes" class="inputbox" name="remember" id="remember">
                </div>
                <button class="button" type="submit">Log in</button>
                <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                </fieldset>
              </form>
            </div>
            <div class="login_links">
              <ul>
                <li> <a class="lost-pwd" href="<?php home_url(); ?>/wp-login.php?action=lostpassword"> Forgot your password?</a> </li>
                <li> <a class="username" href="<?php home_url(); ?>/wp-login.php?action=remind"> Forgot your username?</a> </li>
                <li> <a class="register" href="<?php home_url(); ?>/wp-login.php?action=register"> Don't have an account?</a> </li>
              </ul>
            </div>
          </div>
          <?php 
                        } 
                    ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
