<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 20/07/16
 * Time: 12:13
 */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<div style="background: white;padding: 20px;">
    <section style="padding: 20px;">
        <h2><?php _e('Mise à jour competition', 'apiFoot') ?></h2>
        <p><strong><?php _e('A utiliser quand un championnat et ajouté à l\'api', 'apiFoot'); ?></strong></p>
        <a href="<?php echo $actual_link ?>&updateCompetition=true&token=<?php echo $token->meta_value ?>" class="button button-primary"><?php _e('Mise à jour competition', 'apiFoot') ?></a>
    </section>
    <section style="padding: 20px;">
        <h2><?php _e('Mise à jour classement', 'apiFoot') ?></h2>
        <a href="<?php echo $actual_link ?>&updateStanding=true&token=<?php echo $token->meta_value ?>" class="button button-primary"><?php _e('Mise à jour classement', 'apiFoot') ?></a>
    </section>
    <section style="padding: 20px;">
        <p><strong><?php _e('Mettre à jour le classement avant la team', 'apiFoot'); ?></strong></p>
        <h2><?php _e('Mise à jour Team', 'apiFoot') ?></h2>
        <a href="<?php echo $actual_link ?>&updateTeam=true&token=<?php echo $token->meta_value ?>" class="button button-primary"><?php _e('Mise à jour Team', 'apiFoot') ?></a>
    </section>
    <section style="padding: 20px;">
        <h2><?php _e('Mise à jour Match', 'apiFoot') ?></h2>
        <a href="<?php echo $actual_link ?>&updateMatch=true&token=<?php echo $token->meta_value ?>" class="button button-primary"><?php _e('Mise à jour Match', 'apiFoot') ?></a>
    </section>
    <section style="padding: 20px;">
        <h2><?php _e('Nettoyer la base de donnée des veille entrée', 'apiFoot') ?></h2>
        <a href="<?php echo $actual_link ?>&cleanDB=true&token=<?php echo $token->meta_value ?>" class="button button-primary"><?php _e('Nettoyer la base de donnée des veille entrée', 'apiFoot') ?></a>
    </section>
</div>
