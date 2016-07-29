<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 21/07/16
 * Time: 17:16
 */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<section id="MatchTable">
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

    <?php if($weeks != false): ?>
        <ul class="week">
            <?php $count = count($weeks); ?>
            <?php foreach($weeks as $week): ?>
                <?php if($week->week == $currentWeek): ?>

                    <?php if(1 == $week->week): ?>
                        <li class="week arrow unactive-arrow"><p><</p></li>
                    <?php else: ?>
                        <li class="week arrow"><a href="#" data-week="<?php echo ($week->week-1) ?>" data-id="<?php echo $comp_id ?>"><</a></li>
                    <?php endif; ?>

                    <li class="week"><a href="#" data-week="<?php echo $week->week ?>" data-id="<?php echo $comp_id ?>"><?php echo $week->week ?><?php echo _n('er journée', 'ème journée', $week->week, 'apiFoot') ?></a></li>

                    <?php if($count == $week->week): ?>
                        <li class="week arrow unactive-arrow"><p>></p></li>
                    <?php else: ?>
                        <li class="week arrow"><a href="#" data-week="<?php echo ($week->week+1) ?>" data-id="<?php echo $comp_id ?>">></a></li>

                    <?php endif; ?>
                <?php endif ?>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>


    <?php include_once (__DIR__.'/match-table.php'); ?>


</section>

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