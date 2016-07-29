<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 21/07/16
 * Time: 14:37
 */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<section id="StandingTable" class="StandingTable">
    <?php if($competitions != false): ?>
        <ul class="competition">
            <?php foreach($competitions as $oneCompetition): ?>
                <?php if($comp_id == $oneCompetition->id): ?>
                    <li class="competition selected"><?php echo $oneCompetition->region ?> - <?php echo $oneCompetition->name ?></li>
                <?php endif ?>
            <?php endforeach; ?>
        </ul>
        <ul class="competitionNotSelected hidden menu">
            <?php foreach($competitions as $oneCompetition): ?>
                <?php if($comp_id != $oneCompetition->id): ?>
                    <li class="competition"><a href="#" data-id="<?php echo $oneCompetition->id ?>"><?php echo $oneCompetition->region ?> - <?php echo $oneCompetition->name ?></a></li>
                <?php endif ?>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>

    <?php if($standing != false): ?>
        <table>
            <thead>
                <tr style="border: none">
                    <th colspan="4"></th>
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
                            <td class="position"><?php echo $team->position ?></td>
                            <td class="status">
                                <?php
                                    if($team->status == 'same'){  ?>
                                        <img src="<?php echo plugins_url('/web/img/trend-stable.png', dirname(__FILE__)) ?>" alt="same">
                                   <?php }elseif($team->status == 'up'){ ?>
                                        <img src="<?php echo plugins_url('/web/img/trend-up.png', dirname(__FILE__)) ?>" alt="up">
                                   <?php }elseif($team->status == 'down'){ ?>
                                        <img src="<?php echo plugins_url('/web/img/trend-down.png',dirname( __FILE__)) ?>" alt="down">
                                    <?php }
                                ?>
                            </td>
                            <td>
                                <img src="<?php echo $team->image ?>" alt="<?php echo $team->name ?>">
                            </td>
                            <td class="ident">
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
    <?php else : ?>
        <section class="notFind">
            <p><?php _e('Pas de classement disponible', 'apiFoot') ?></p>
        </section>
    <?php endif; ?>

</section>
<script async>
    jQuery('#StandingTable').on('click', '.competition a', function(e){
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
