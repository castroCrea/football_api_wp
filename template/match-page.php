<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 21/07/16
 * Time: 17:16
 */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<div id="MatchTable">
    <ul class="competition">
        <?php foreach($competitions as $oneCompetition): ?>
            <?php if($comp_id == $oneCompetition->id): ?>
                <li class="competition selected"><a href="#" style="color: red;"  data-id="<?php echo $oneCompetition->id ?>"><?php echo $oneCompetition->name ?></a></li>
            <?php else : ?>
                <li class="competition"><a href="#"  data-id="<?php echo $oneCompetition->id ?>"><?php echo $oneCompetition->name ?></a></li>
            <?php endif ?>
        <?php endforeach; ?>
    </ul>

    <?php if($weeks != false): ?>
        <ul class="week">
            <?php foreach($weeks as $week): ?>
                <?php if($week->week == $currentWeek): ?>
                    <li class="week selected"><a href="#" style="color: red;" data-week="<?php echo $week->week ?>" data-id="<?php echo $comp_id ?>"><?php echo $week->week ?><?php echo _n('er journée', 'ème journée', $week->week, 'apiFoot') ?></a></li>
                <?php else : ?>
                    <li class="week"><a href="#" data-week="<?php echo $week->week ?>" data-id="<?php echo $comp_id ?>"><?php echo $week->week ?><?php echo _n('er journée', 'ème journée', $week->week, 'apiFoot') ?></a></li>
                <?php endif ?>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>


    <?php include_once (__DIR__.'/match-table.php'); ?>


</div>

<script async>
    jQuery('#MatchTable').on('click', '.competition a', function(e){
            e.preventDefault();
            var comp_id = jQuery(this).data('id');
            ajax(comp_id);
        }
    );
    jQuery('#MatchTable').on('click', '.week a', function(e){
            e.preventDefault();
            var comp_id = jQuery(this).data('id');
            var week = jQuery(this).data('week');
            ajax(comp_id, week);
        }
    );

    function ajax(comp_id, week = null){
        var url = '<?php echo $actual_link ?>';
        if(week === null){
            var data = { MatchCompetition : true, comp_id : comp_id };
        }else{
            var data = { MatchCompetition : true, comp_id : comp_id, week : week };
        }
        jQuery.post(url, data, function(data){
            var content = jQuery(jQuery.parseHTML(data)).html();
            console.log(content);
            jQuery('#MatchTable').html(content);


        });
    }
</script>