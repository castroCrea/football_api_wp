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
                <li class="competition selected" data-id="<?php echo $oneCompetition->id ?>"><a href="#"><?php echo $oneCompetition->name ?></a></li>
            <?php else : ?>
                <li class="competition" data-id="<?php echo $oneCompetition->id ?>"><a href="#"><?php echo $oneCompetition->name ?></a></li>
            <?php endif ?>
        <?php endforeach; ?>
    </ul>

    <?php if($weeks != false): ?>
        <ul class="week">
            <?php foreach($weeks as $week): ?>
                <?php if($week->week == $currentWeek): ?>
                    <li class="week selected" data-week="<?php echo $week->week ?>"><a href="#"><?php echo $week->week ?><?php echo _n('er journée', 'ème journée', $week->week, 'apiFoot') ?></a></li>
                <?php else : ?>
                    <li class="week" data-id="<?php echo $week->week ?>"><a href="#"><?php echo $week->week ?><?php echo _n('er journée', 'ème journée', $week->week, 'apiFoot') ?></a></li>
                <?php endif ?>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>


    <?php include_once (__DIR__.'/match-table.php'); ?>


</div>