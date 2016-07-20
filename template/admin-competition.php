<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 19/07/16
 * Time: 12:24
 */

if($allCompetition): ?>
    <form method="post" style="background: white;padding: 20px;overflow-y: auto">
        <input type="hidden" name="updateCompetition" value="true">
        <ul style="background: rgba(128, 128, 128, 0.09);padding: 20px;">
            <?php foreach($allCompetition as $competition): ?>
                <li style="border-bottom: 1px solid lightgrey;padding-bottom: 10px">
                    <?php if($competition->status == 0): ?>
                        <label for="<?php echo $competition->id ?>" style="width: 300px;display: inline-block;"><input type="checkbox" name="competition[]" id="<?php echo $competition->id ?>" value="<?php echo $competition->id ?>"><?php echo $competition->name ?></label>
                    <?php else: ?>
                        <label for="<?php echo $competition->id ?>" style="width: 300px;display: inline-block;"><input type="checkbox" name="competition[]" id="<?php echo $competition->id ?>" value="<?php echo $competition->id ?>" checked><?php echo $competition->name ?></label>
                    <?php endif ?>
                    <label for="date_from<?php echo $competition->id ?>"><?php _e('Date de bébut', 'apiFoot') ?> : <input type="text" name="date_from[<?php echo $competition->id ?>]" id="date_from<?php echo $competition->id ?>" value="<?php echo $competition->date_from ?>" checked></label>
                    <label for="date_to<?php echo $competition->id ?>"><?php _e('Date de fin', 'apiFoot') ?> : <input type="text" name="date_to[<?php echo $competition->id ?>]" id="date_to<?php echo $competition->id ?>" value="<?php echo $competition->date_to ?>" checked></label>
                </li>
            <?php endforeach ?>
        </ul>
        <input type="submit" value="<?php _e('valider','apiFoot') ?>">
    </form>
<?php endif ?>

