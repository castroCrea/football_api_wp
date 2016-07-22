<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 22/07/16
 * Time: 14:44
 */

?>
<?php if($allMatch != false): ?>
<ul id="allMatch">
    <?php foreach($allMatch as $match): ?>
        <li>
            <div class="Team">
                <p><img src="<?php echo $match->localteam_image ?>" alt="<?php echo $match->localteam_name ?>" ></p>
                <p><strong><?php echo $match->localteam_name ?></strong></p>
            </div>
            <div class="score">
                <?php if($match->localteam_score != 0 && $match->visitorteam_score != 0): ?>
                    <p><strong><?php echo $match->localteam_score ?> - <?php echo $match->visitorteam_score ?></strong></p>
                    <?php if($match->et_score != null): ?><p><?php _e('(a.p)','apiFoot') ?></p><?php endif; ?>
                    <?php if($match->penalty_local != null && $match->penalty_visitor != null): ?><p><?php echo $match->penalty_local ?> - <?php echo $match->penalty_visitor ?> <?php _e('(t.a.b)','apiFoot') ?></p><?php endif; ?>
                <?php else: ?>
                    <p><?php echo date('d/m/Y',$match->formatted_date) ?></p>
                    <p><?php echo $match->time ?></p>
                <?php endif; ?>
            </div>
            <div class="Team">
                <p><img src="<?php echo $match->visitorteam_image ?>" alt="<?php echo $match->visitorteam_name ?>" ></p>
                <p><strong><?php echo $match->visitorteam_name ?></strong></p>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
