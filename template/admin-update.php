<?php
/**
 * Created by PhpStorm.
 * User: paolo
 * Date: 20/07/16
 * Time: 12:13
 */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]?page=api-update";
?>

<div style="background: white;padding: 20px;">
    <section style="padding: 20px;">
        <h2><?php _e('Mise à jour competition', 'apiFoot') ?></h2>
        <p><strong><?php _e('A utiliser quand un championnat et ajouté à l\'api', 'apiFoot'); ?></strong></p>
        <a href="<?php echo $actual_link ?>&insertCompetition=true&token=<?php echo $token->meta_value ?>" class="button button-primary update"><?php _e('Mise à jour competition', 'apiFoot') ?></a><?php if(isset($_GET['insertCompetition']) && isset($_SESSION['updateApi'])): ?><p style="padding-left: 10px;display: inline-block;margin: 5px 0;"><?php if($_SESSION['updateApi']) : ?><?php _e('Bien mis à jour','apiFoot') ?><?php else: ?><?php _e('Problème. Avez-vous selectionné des competitions ?', 'apiFoot') ?><?php endif; ?></p><?php endif; ?>
    </section>
    <section style="padding: 20px;">
        <h2><?php _e('Mise à jour classement', 'apiFoot') ?></h2>
        <a href="<?php echo $actual_link ?>&updateStanding=true&token=<?php echo $token->meta_value ?>" class="button button-primary update"><?php _e('Mise à jour classement', 'apiFoot') ?></a><?php if(isset($_GET['updateStanding']) && isset($_SESSION['updateApi'])): ?><p style="padding-left: 10px;display: inline-block;margin: 5px 0;"><?php if($_SESSION['updateApi']) : ?><?php _e('Bien mis à jour','apiFoot') ?><?php else: ?><?php _e('Problème. Avez-vous selectionné des competitions ?', 'apiFoot') ?><?php endif; ?></p><?php endif; ?>
    </section>
    <section style="padding: 20px;">
        <p><strong><?php _e('Mettre à jour le classement avant la team', 'apiFoot'); ?></strong></p>
        <h2><?php _e('Mise à jour Team', 'apiFoot') ?></h2>
        <a href="<?php echo $actual_link ?>&updateTeam=true&token=<?php echo $token->meta_value ?>" class="button button-primary update"><?php _e('Mise à jour Team', 'apiFoot') ?></a><?php if(isset($_GET['updateTeam']) && isset($_SESSION['updateApi'])): ?><p style="padding-left: 10px;display: inline-block;margin: 5px 0;"><?php if($_SESSION['updateApi']) : ?><?php _e('Bien mis à jour','apiFoot') ?><?php else: ?><?php _e('Problème. Avez-vous selectionné des competitions , mise à jours les classements?', 'apiFoot') ?><?php endif; ?></p><?php endif; ?>
    </section>
    <section style="padding: 20px;">
        <h2><?php _e('Mise à jour Match', 'apiFoot') ?></h2>
        <a href="<?php echo $actual_link ?>&updateMatch=true&token=<?php echo $token->meta_value ?>" class="button button-primary update"><?php _e('Mise à jour Match', 'apiFoot') ?></a><?php if(isset($_GET['updateMatch']) && isset($_SESSION['updateApi'])): ?><p style="padding-left: 10px;display: inline-block;margin: 5px 0;"><?php if($_SESSION['updateApi']) : ?><?php _e('Bien mis à jour','apiFoot') ?><?php else: ?><?php _e('Problème. Avez-vous selectionné des competitions ?', 'apiFoot') ?><?php endif; ?></p><?php endif; ?>
    </section>
    <section style="padding: 20px;">
        <h2><?php _e('Nettoyer la base de donnée des veille entrée', 'apiFoot') ?></h2>
        <a href="<?php echo $actual_link ?>&cleanDB=true&token=<?php echo $token->meta_value ?>" class="button button-primary update"><?php _e('Nettoyer la base de donnée des veille entrée', 'apiFoot') ?></a><?php if(isset($_GET['cleanDB']) && isset($_SESSION['updateApi'])): ?><p style="padding-left: 10px;display: inline-block;margin: 5px 0;"><?php if($_SESSION['updateApi']) : ?><?php _e('Bien mis à jour','apiFoot') ?><?php else: ?><?php _e('Problème. Contactez-le support technique ?', 'apiFoot') ?><?php endif; ?></p><?php endif; ?>
    </section>
</div>