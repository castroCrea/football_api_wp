<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 19/07/16
 * Time: 12:24
 */

if($allCompetition): ?>
    <form method="post" style="background: white;padding: 20px;">
        <input type="hidden" name="updateCompetition" value="true">
        <ul style="background: rgba(128, 128, 128, 0.09);padding: 20px;">
            <?php foreach($allCompetition as $competition): ?>
                <li>
                    <?php if($competition->status == 0): ?>
                        <label for="<?php echo $competition->id ?>"><input type="checkbox" name="competition[]" id="<?php echo $competition->id ?>" value="<?php echo $competition->id ?>"><?php echo $competition->name ?></label>
                    <?php else: ?>
                        <label for="<?php echo $competition->id ?>"><input type="checkbox" name="competition[]" id="<?php echo $competition->id ?>" value="<?php echo $competition->id ?>" checked><?php echo $competition->name ?></label>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>
        <input type="submit" value="<?php _e('valider','apiFoot') ?>">
    </form>
<?php endif ?>

