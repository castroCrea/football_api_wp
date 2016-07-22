<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 19/07/16
 * Time: 12:24
 */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]?page=api-team";
?>
    <div style="background: white;padding: 20px;">
        <h1><?php _e('Gestions du nom et logo des equipes', 'apiFoot'); ?></h1>
        <h2><?php _e('Ordre alphabétique','apiFoot'); ?></h2>
        <?php foreach($teams as $oneTeam): ?>
            <form method="post" style="padding: 10px 0;border-top: 1px solid lightgrey;">
                <input type="hidden" name="udateTeam" value="true">
                <input type="hidden" name="teamId" value="<?php echo $oneTeam->id ?>">
                <label for="<?php echo $oneTeam->name ?>"><?php _e('Nom équipes','apiFoot') ?> : <input type="text" name="name" value="<?php echo $oneTeam->name ?>" id="<?php echo $oneTeam->name ?>"></label>
                <label for="image<?php echo $oneTeam->id ?>"><?php _e('Logo équipes','apiFoot') ?> : <input type="text" name="image" value="<?php if($oneTeam->image != null){ echo $oneTeam->image; }else{ echo ''; } ?>" id="image<?php echo $oneTeam->id ?>"></label>
                <input type="submit" value="<?php _e('Valider','apiFoot') ?>" class="button button-primary submit">
                <span style="padding-left:10px;"></span>
            </form>
        <?php endforeach; ?>
        <div  style="padding: 10px;">
            <a class="button button-primary" id="allSubmit"><?php _e('Valider tout', 'apiFoot') ?></a>
        </div>
    </div>
    <script async>
        jQuery('form').submit(function(e){
                e.preventDefault();
                ajax(jQuery(this));
            }
        );


        jQuery('#allSubmit').click(function(){
            jQuery('form').each(function(){
                jQuery(this).trigger('submit');
            });
        });

        function ajax($this){
            var url = '<?php echo $actual_link ?>';
            var data = $this.serializeArray();
            jQuery.post(url, data, function(data){
                console.log(data == 1);
                if(data == 1){
                    $this.children('span').html('<?php _e('Bien enregistré','apiFoot') ?>');
                }else{
                    $this.children('span').html('<?php _e('Problème de saisie','apiFoot') ?>');
                }
            });
        }
    </script>

