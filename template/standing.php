<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 21/07/16
 * Time: 14:37
 */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<div id="StandingTable">
    <ul>
        <?php foreach($competitions as $oneCompetition): ?>
            <?php if($comp_id == $oneCompetition->id): ?>
                <li class="competition selected" data-id="<?php echo $oneCompetition->id ?>"><a href="#"><?php echo $oneCompetition->name ?></a></li>
            <?php else : ?>
                <li class="competition" data-id="<?php echo $oneCompetition->id ?>"><a href="#"><?php echo $oneCompetition->name ?></a></li>
            <?php endif ?>
        <?php endforeach; ?>
    </ul>

    <table>
        <thead>
            <tr style="border: none">
                <th colspan="3"></th>
                <th><?php _e('Pts', 'apiFoot') ?></th>
                <th><?php _e('J', 'apiFoot') ?></th>
                <th><?php _e('G', 'apiFoot') ?></th>
                <th><?php _e('N', 'apiFoot') ?></th>
                <th><?php _e('P', 'apiFoot') ?></th>
                <th><?php _e('Diff', 'apiFoot') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $group = null; ?>
        <?php foreach($standing as $team): ?>
            <?php if($team->comp_group != null): ?>
                <?php if($team->comp_group != $group): ?>
                    <tr>
                        <td colspan="9"><?php echo $team->comp_group ?></td>
                    </tr>
                <?php endif; ?>
                <?php $group = $team->comp_group; ?>
            <?php endif; ?>
                <tr>
                    <td><?php echo $team->position ?></td>
                    <td>
                        <?php
                            if($team->status == 'same'){  ?>
                                <img src="http://www2.ac-lyon.fr/etab/ien/loire/ressources/mathematiques42/local/cache-vignettes/L112xH78/arton46-fbfb5.jpg" alt="<?php echo $team->name ?>">
                           <?php }elseif($team->status == 'up'){ ?>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/50/Green_Arrow_Up.svg" alt="<?php echo $team->name ?>">
                           <?php }elseif($team->status == 'down'){ ?>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Red_Arrow_Down.svg" alt="<?php echo $team->name ?>">
                            <?php }
                        ?>
                    </td>
                    <td>
                        <img src="<?php echo $team->image ?>" alt="<?php echo $team->name ?>">
                        <h2><?php echo $team->name ?></h2>
                    </td>
                    <td>
                        <?php echo $team->point ?>
                    </td>
                    <td>
                        <?php echo $team->round ?>
                    </td>
                    <td>
                        <?php echo $team->overall_w ?>
                    </td>
                    <td>
                        <?php echo $team->overall_d ?>
                    </td>
                    <td>
                        <?php echo $team->overall_l ?>
                    </td>
                    <td>
                        <?php echo $team->gd ?>
                    </td>
                </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
    <script async>
        jQuery('#StandingTable').on('click', '.competition', function(e){
                e.preventDefault();
                var comp_id = jQuery(this).data('id');
                ajax(comp_id);
            }
        );

        function ajax(comp_id){
            var url = '<?php echo $actual_link ?>';
            var data = { StandingCompetition : true, comp_id : comp_id };
            jQuery.post(url, data, function(data){
                var content = jQuery(jQuery.parseHTML(data)).html();
                jQuery('#StandingTable').html(content);


            });
        }
    </script>
