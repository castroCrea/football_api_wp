<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 19/07/16
 * Time: 12:24
 */

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($allCompetition): ?>
    <form method="post" style="background: white;padding: 20px;overflow-y: auto">
        <input type="hidden" name="updateCompetition" value="true">
        <ul style="background: rgba(128, 128, 128, 0.09);padding: 20px;">
            <?php foreach($allCompetition as $competition): ?>
                <li style="border-bottom: 1px solid lightgrey;padding-bottom: 10px">
                    <?php if($competition->status == 0): ?>
                        <label for="<?php echo $competition->id ?>" style="width: 250px;display: inline-block;"><input type="checkbox" name="competition[]" id="<?php echo $competition->id ?>" value="<?php echo $competition->id ?>"><?php echo $competition->name ?></label>
                    <?php else: ?>
                        <label for="<?php echo $competition->id ?>" style="width: 250px;display: inline-block;"><input type="checkbox" name="competition[]" id="<?php echo $competition->id ?>" value="<?php echo $competition->id ?>" checked><?php echo $competition->name ?></label>
                    <?php endif ?>
                    <p style="display: inline-block; width: 120px"><?php echo $competition->region ?></p>
                    <label for="date_from<?php echo $competition->id ?>" style="padding-right: 10px;"><?php _e('Date de bébut', 'apiFoot') ?> : <input type="text" name="date_from[<?php echo $competition->id ?>]" id="date_from<?php echo $competition->id ?>" value="<?php echo $competition->date_from ?>"></label>
                    <label for="date_to<?php echo $competition->id ?>" style="padding-right: 10px;"><?php _e('Date de fin', 'apiFoot') ?> : <input type="text" name="date_to[<?php echo $competition->id ?>]" id="date_to<?php echo $competition->id ?>" value="<?php echo $competition->date_to ?>"></label>
                    <label for="classement<?php echo $competition->id ?>" style="padding-right: 10px;"><?php _e('Votre ordre de préfèrence', 'apiFoot') ?> : <input type="number" name="classement[<?php echo $competition->id ?>]" id="classement<?php echo $competition->id ?>" value="<?php echo $competition->classement ?>"  style="width: 50px;"></label>
                    <select name="season[<?php echo $competition->id ?>]">
                        <?php foreach($season as $oneSeason): ?>
                            <?php if($oneSeason->season == $competition->season): ?>
                                <option value="<?php echo $oneSeason->season ?>" selected><?php echo $oneSeason->season ?></option>
                            <?php else: ?>
                                <option value="<?php echo $oneSeason->season ?>"><?php echo $oneSeason->season ?></option>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </select>
                </li>
            <?php endforeach ?>
        </ul>
        <input class="button button-primary" type="submit" value="<?php _e('Valider','apiFoot') ?>">
    </form>
<?php else: ?>
    <a class="button button-primary" href="<?php echo $actual_link ?>"><?php _e('Charger les championnats', 'apiFoot') ?></a>
<?php endif ?>

