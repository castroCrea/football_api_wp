<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 19/07/16
 * Time: 12:24
 */
?>
    <form method="post" style="background: white;padding: 20px;">
        <input type="hidden" name="updateKey" value="true">
        <label for="apiKey"><?php _e('clé de l\'api','apiFoot') ?> : <input type="text" name="apiKey" value="<?php if($api != false): echo $api->meta_value; endif; ?>" id="apiKey"></label>
        <input type="submit" value="<?php _e('valider','apiFoot') ?>" class="button button-primary">
    </form>

