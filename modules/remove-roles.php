<?php
namespace Kokku\Cleanup\RemoveRoles;

/*
 * Disable WordPress Default Roles
 *
 * You can enable/disable this feature in functions.php:
 * add_theme_support('kokku-remove-roles');
*/

add_action( 'admin_init', function () {

  //remove_role( 'administrator' );

  remove_role( 'editor' );

  remove_role( 'author' );

  remove_role( 'contributor' );

  remove_role( 'subscriber' );

});

 ?>
