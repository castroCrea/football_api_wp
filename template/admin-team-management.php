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
                <label for="image<?php echo $oneTeam->id ?>"><?php _e('Logo équipes','apiFoot') ?> : <input type="text" name="image" value="<?php if($oneTeam->image != null){ echo $oneTeam->image; }else{ echo ''; } ?>" id="image<?php echo $oneTeam->id ?>"><input class="upload_image_button button button-primary" type="button" value="Upload Image" /></label>
                <input type="submit" value="<?php _e('Valider','apiFoot') ?>" class="button button-primary submit" style="margin-left: 10px">
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

        jQuery(document).on("click", ".upload_image_button", function() {

            var elmtParent  = jQuery(this).prev();

            console.log(elmtParent);

            jQuery.data(document.body, 'prevElement', jQuery(this).prev());

            window.send_to_editor = function(html) {
                var imgurl = jQuery(html).children().attr('src');
                if(typeof jQuery(html).children().attr('src') != 'string'){
                    var imgurl = jQuery(html).attr('src');
                };
                var inputText = jQuery.data(document.body, 'prevElement');


                if(inputText != undefined && inputText != '')
                {
                    elmtParent.val(imgurl);
                }

                tb_remove();
            };

            tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            return false;
        });
    </script>

